<?php
define('SITE_NAME', '有个留言薄');
define('SITE_TIMEZONE', 'Asia/Shanghai');
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'guestbook');
define('DB_CHARSET', 'utf8');
define('PAGINATION_LIMIT', 5);
define('PUBLIC_FREQ', 60);

date_default_timezone_set(SITE_TIMEZONE);
session_start();


function dbConnect()
{
	$dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET;
	return new PDO($dsn, DB_USER, DB_PASS, [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	]);

}

function pagination($total, $limit, $page)
{
	$page_total = ceil($total/$limit);
	$offset = ($page * $limit) - $limit;

	return [
		'page' => $page,
		'total' => $total,
		'limit' => $limit,
		'page_total' => $page_total,
		'offset' => $offset < 0 ? 0 : $offset,
		'page_next' => $page > ($page_total - 1) ? $page_total : $page + 1,
		'page_prev' => $page < 2 ? 1 : $page - 1,

	];
}

function url(array $params = []) {
	$urlPath = dirname($_SERVER['SCRIPT_NAME']);
	if (strlen($urlPath) < 2) {
		$urlPath = '';
	}
	return $urlPath.'/?'.http_build_query($params);
}

function assertURL($filename) {
	$urlPath = dirname($_SERVER['SCRIPT_NAME']);
	if (strlen($urlPath) < 2) {
		$urlPath = '';
	}
	return $urlPath.'/assets/'.$filename;
}

function backURL()
{
	return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : url();
}

function redirect($url)
{
	header('Location: '.$url);
	exit();
}


function adminIsLogin()
{
	return isset($_SESSION['IS_ADMIN']) && $_SESSION['IS_ADMIN'] === true;
}

function setFlashMessage($message)
{
	$_SESSION['flash_message'] = $message;
}

function getFlashMessage()
{
	$message = '';
	if (isset($_SESSION['flash_message'])) {
		$message = $_SESSION['flash_message'];
		$_SESSION['flash_message'] = null;
	}
	return $message;
}

function arrayFind(array $data, $name, $default = null)
{
	return isset($data[$name]) ? $data[$name] : $default;
}

function getParam($name, $default='')
{
	$value = arrayFind($_GET, $name, $default);
	if (isset($_POST[$name])) {
		$value = $_POST[$name];
	}
	return trim($value);
}

function canEdit(array $comment)
{
	if (adminIsLogin()) {
		return true;
	}

	if (isset($_SESSION['AUTHOR_EMAIL']) && $comment['email'] == $_SESSION['AUTHOR_EMAIL']) {
		return true;
	}
	return false;
}

function signAuthor($email)
{
	$_SESSION['AUTHOR_EMAIL'] = $email;
}

function getCommentParam()
{
	$email = getParam('email');
	$username = getParam('username');
	$content = getParam('content');


	if (empty($email)) {
		setFlashMessage('请输入你的电子邮箱');
		redirect(backURL());
	}

	// 使用简单的 Email 验证规则
	if (!preg_match('/^\w+@\w+$/', $email)) {
		setFlashMessage('请输入有效的电子邮箱');
		redirect(backURL());
	}

	if (empty($content)) {
		setFlashMessage('请输入你的留言内容');
		redirect(backURL());
	}

	return [
		'email' => htmlentities($email),
		'username' => htmlentities($username),
		'content' => htmlentities($content),
		'ip' => isset($_SERVER['REMOTE_ADDR']) ? ip2long($_SERVER['REMOTE_ADDR']) : null,
		'created_at' => date('Y-m-d H:i:s'),
		'updated_at' => date('Y-m-d H:i:s'),
	];
}


class DB
{
	protected static $connection = null;

	public static function connect()
	{
		if (!self::$connection) {
			$dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET;
			self::$connection = new PDO($dsn, DB_USER, DB_PASS, [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			]);
		}
		return self::$connection;
	}

	public static function query($sql, array $arguments = [])
	{
		self::connect();
		$query = self::$connection->prepare($sql);
		$query->execute($arguments);
		return $query;
	}
}

class Comment
{

	public static function find($id)
	{
		$query = DB::query('SELECT * FROM comments WHERE id=? LIMIT 1', [$id]);
		return $query->fetch(PDO::FETCH_ASSOC);
	}


	public static function create(array $data)
	{
		$db = DB::connect();

		$query = $db->prepare('INSERT INTO comments(email, ip, username, content, created_at) VALUES(:email, :ip, :username, :content, :created_at)');
		$query->bindParam(':email', $data['email'], PDO::PARAM_STR);
		$query->bindParam(':ip', $data['ip'], PDO::PARAM_STR);
		$query->bindParam(':username', $data['username'], PDO::PARAM_STR);
		$query->bindParam(':content', $data['content'], PDO::PARAM_STR);
		$query->bindParam(':created_at', $data['created_at'], PDO::PARAM_STR);
		$query->execute();
	}

	public static function update($id, array $data)
	{
		$db = DB::connect();

		$query = $db->prepare('UPDATE comments SET email=:email, username=:username, content=:content, updated_at=:updated_at WHERE id=:id');
		$query->bindParam(':id', $id, PDO::PARAM_INT);
		$query->bindParam(':email', $data['email'], PDO::PARAM_STR);
		$query->bindParam(':username', $data['username'], PDO::PARAM_STR);
		$query->bindParam(':content', $data['content'], PDO::PARAM_STR);
		$query->bindParam(':updated_at', $data['updated_at'], PDO::PARAM_STR);
		$query->execute();
	}

	public static function destroy($id)
	{
		DB::query('DELETE FROM comments WHERE id=? LIMIT 1', [$id]);
	}

	public static function listOf(array $params = [])
	{
		$db = DB::connect();

		$page = (int) arrayFind($params, 'page', 1);
		$total = (int) $db->query('SELECT COUNT(id) FROM comments')->fetch()[0];
		$pagination = pagination($total, PAGINATION_LIMIT, $page);
		$query = $db->prepare('SELECT * FROM comments ORDER BY id DESC LIMIT :offset, :limit');
		$query->bindParam(':offset', $pagination['offset'], PDO::PARAM_INT);
		$query->bindParam(':limit', $pagination['limit'], PDO::PARAM_INT);
		$query->execute();

		return [
			'items' => $query->fetchAll(PDO::FETCH_ASSOC),
			'pagination' => $pagination,
		];
	}

	public static function formatContent($text)
	{
		return nl2br($text);
	}

	public static function formatDate($strTime)
	{
		return date('Y-m-d H:i:s', strtotime($strTime));
	}

	public static function formatIP($intIP)
	{
		return long2ip($intIP);
	}


	public static function denyPublicBy(array $data)
	{
		$ip = arrayFind($data, 'ip');
		$comment = DB::query('SELECT created_at FROM comments WHERE ip=? ORDER BY id DESC LIMIT 1', [$ip])->fetch(PDO::FETCH_ASSOC);
		if ($comment) {
			return (time() - strtotime($comment['created_at'])) < PUBLIC_FREQ;
		}
		return true;
	}
}


$db = DB::connect();
$adminUsers = [
	'test' => 'test',
	'haha' => '123456',
];


$actionLogin = function() use($adminUsers) {
	$realm = 'Admin Login';
	$doLogin = function() use($realm) {
		header('HTTP/1.1 401 Unauthorized');
		header('WWW-Authenticate: Digest realm="'.$realm.'",qop="auth",nonce="'.uniqid().'",opaque="'.md5($realm).'"');
		die('<script type="text/javascript">history.back();</script>');

	};


	if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
		$doLogin();
	}


	$arguments = [
		'nonce' => null,
		'nc' => null,
		'cnonce' => null,
		'qop' => null,
		'username' => null,
		'uri' => null,
		'response' => null,
	];

	$params = [];

	preg_match_all('/([^, ]+?)=([\'"](.*?)[\'"]|([^, ]+))/', $_SERVER['PHP_AUTH_DIGEST'], $matches);
	foreach ($matches[1] as $i => $rs) {
		$params[$rs] = $matches[3][$i] ? $matches[3][$i] : $matches[4][$i];
	}

	if (!isset($adminUsers[$params['username']])) {

		$doLogin();
	}

	$s1 = md5($params['username'].':'.$realm.':'.$adminUsers[$params['username']]);
	$s2 = md5($_SERVER['REQUEST_METHOD'].':'.$params['uri']);
	$responseVerify = md5($s1.':'.$params['nonce'].':'.$params['nc'].':'.$params['cnonce'].':'.$params['qop'].':'.$s2);

	if ($responseVerify != $params['response']) {
		$doLogin();
	}

	$_SESSION['IS_ADMIN'] = true;


	redirect(url());
};


$actionLogout = function() {
	$_SESSION['IS_ADMIN'] = false;
	redirect(url());
};

$actionIndex = function() use($db) {
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$result = Comment::listOf(['page' => arrayFind($_GET,'page', 1)]);
	$pagination = $result['pagination'];
	?>


	<div class="container">
		<header class="page">
			<a class="btn" href="<?php echo url(['action' => 'new']) ?>">发表</a>
		</header>
		<div>
			<?php foreach($result['items'] as $rs) { ?>

				<article>
					<div><?php echo Comment::formatContent($rs['content']) ?></div>

					<footer>

						<time datetime=<?php echo $rs['created_at'] ?>><?php echo Comment::formatDate($rs['created_at']) ?></time>

						by <span class="author"><?php echo $rs['username'] ? $rs['username'] : '无名氏' ?></span> 

						from <span class="ip"><?php echo Comment::formatIP($rs['ip']) ?></span>

						<?php if (canEdit($rs)) { ?>
						<div class="actions">
							<a class="btn" href="<?php echo url(['action' => 'edit', 'id' => $rs['id']]) ?>">修改</a>
							<a class="btn" href="<?php echo url(['action' => 'destroy', 'id' => $rs['id']]) ?>" onclick="return confirm('确定要删除此留言吗？')">删除</a>
						</div>
						<?php } ?>
					</footer>
				</article>
			<?php } ?>
		</div>

		<div class="pagination">
			<?php if ($pagination['page'] > 1) { ?>
			<a href="<?php echo url(['page' => $pagination['page_prev']]) ?>">上页</a>
			<?php } ?>
			<span><?php echo $page ?> / <?php echo $pagination['page_total'] ?></span>
			<?php if ($pagination['page'] < $pagination['page_total']) { ?>
			<a href="<?php echo url(['page' => $pagination['page_next']]) ?>">下页</a>
			<?php } ?>
		</div>
	</div>
	<?php

};


$actionNew = function() {
	?>
	<div class="container">
		<header class="page">
			<h1>发布留言</h1>
			<a class="btn" href="<?php echo url() ?>">返回</a>
		</header>


		<form action="<?php echo url(['action' => 'create']) ?>" method="post">
			<div>
				<input name="email" type="text" placeholder="电子邮箱" />
			</div>
			<div>
				<input name="username" type="text" placeholder="网名" />
			</div>
			<div>
				<textarea name="content" placeholder="留言内容..." rows="20"></textarea>
			</div>
			<div>
				<button class="btn" type="submit">提交</button>
			</div>
		</form>
	</div>
	<?php
};

$actionCreate = function() {
	if (!$_POST) {
		setFlashMessage('无效的请求');
		redirect(url());
	}

	$data = getCommentParam();
	if (Comment::denyPublicBy($data)) {
		setFlashMessage('暂时不允许发表留言，请稍后再试');
		redirect(url());
	}

	Comment::create($data);
	signAuthor($data['email']);
	redirect(url());
};

$actionEdit = function() {
	$id = (int) arrayFind($_GET, 'id');
	$comment = Comment::find($id);
	if (!$comment) {
		setFlashMessage('留言不存在');
		redirect(url());
	}
	if (!canEdit($comment)) {
		setFlashMessage('没有编辑此留言的权限');
		redirect(url());
	}
	?>
	<div class="container">
		<header class="page">
			<h1>修改留言</h1>
			<a class="btn" href="<?php echo url() ?>">返回</a>
		</header>

		<form action="<?php echo url(['action' => 'update', 'id' => $comment['id']]) ?>" method="post">
			<div>
				<input name="email" type="text" placeholder="电子邮箱" value="<?php echo $comment['email'] ?>" />
			</div>
			<div>
				<input name="username" type="text" placeholder="网名" value="<?php echo $comment['username'] ?>" />
			</div>
			<div>
				<textarea name="content" placeholder="留言内容..." rows="20"><?php echo $comment['content'] ?></textarea>
			</div>
			<div>
				<button class="btn" type="submit">提交</button>
			</div>
		</form>
	</div>
	<?php
};

$actionUpdate = function() {
	if (!$_POST) {
		redirect(url());
	}

	$data = getCommentParam();
	if (Comment::denyPublicBy($data)) {
		setFlashMessage('暂时不允许发表留言，请稍后再试');
		redirect(url());
	}


	$id = (int) arrayFind($_GET, 'id');
	$comment = Comment::find($id);
	if (!$comment) {
		setFlashMessage('未找到要编辑的留言');
		redirect(url());
	}

	if (!canEdit($comment)) {
		setFlashMessage('没有编辑此留言的权限');
		redirect(url());
	}

	Comment::update($id, $data); 
	signAuthor($data['email']);
	redirect(url());

};

$actionDestroy = function() {
	$id = (int) getParam('id');
	$comment = Comment::find($id);
	if ($comment && canEdit($comment)) {
		Comment::destroy($id);
	}
	redirect(url());
};

?><DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<title><?php echo SITE_NAME ?></title>
<link rel="stylesheet" text="text/css" href="<?php echo assertURL('style.css') ?>" />
</head>
<body>
	<header id="page-top">
		<a href="<?php echo url() ?>" class="logo"><?php echo SITE_NAME ?></a>
	</header>

	<?php $message = getFlashMessage(); ?>
	<?php if ($message) { ?>
	<div class="container">
		<p class="message"><?php echo $message; ?></p>
	</div>
	<?php } ?>

	<?php
		$routes = [
			'login' => $actionLogin,
			'logout' => $actionLogout,
			'index' => $actionIndex,
			'new' => $actionNew,
			'create' => $actionCreate,
			'edit' => $actionEdit, 
			'update' => $actionUpdate,
			'destroy' => $actionDestroy
			];

		$action = 'index';

		if (isset($_GET['action']) && isset($routes[$_GET['action']])) {
			$action = $_GET['action'];
		}

		$routes[$action]();
	?>
	<footer id="page-bottom">
		<?php if (adminIsLogin()) { ?>
		<a href="<?php echo url(['action'=>'logout']) ?>">退出管理</a>
		<?php } else { ?>
		<a href="<?php echo url(['action'=>'login']) ?>">管理登录</a>
		<?php } ?>
	</footer>
</body>
</html>
