<?php
defined('VERSION') or die('deny access');

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

function url($params = null) {
	$urlPath = dirname($_SERVER['SCRIPT_NAME']);
	if (strlen($urlPath) < 2) {
		$urlPath = '';
	}

	if (!$params) {
		return $urlPath.'/';
	}

	if (is_string($params)) {
		$params = ['action' => $params];
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

	if (is_string($value)) {
		return trim($value);
	}

	return $value;
}

function can($permissionCode, $resource)
{
	$user = currentUser();
	if (!$user) {
		return false;
	}

	$permissions = User::findPermissions($user['id']);
	if (in_array('manage', $permissions)) {
		return true;
	}

	if ($resource['user_id'] == $user['id'] && in_array($permissionCode, $permissions)) {
		return true;
	}

	return false;
}

function signAuthor($email)
{
	$_SESSION['AUTHOR_EMAIL'] = $email;
}

function signLogin($user)
{
	$_SESSION['u_id'] = $user['id'];
	$_SESSION['u_token'] = $user['password'];
}

function signLogout()
{
	$_SESSION['u_id'] = null;
	$_SESSION['u_token'] = null;
}

function getCommentParam()
{
	$content = getParam('content');


	if (empty($content)) {
		setFlashMessage('请输入你的留言内容');
		redirect(backURL());
	}

	return [
		'user_id' => (int) arrayFind($_SESSION, 'u_id'),
		'content' => htmlentities($content),
		'ip' => isset($_SERVER['REMOTE_ADDR']) ? ip2long($_SERVER['REMOTE_ADDR']) : null,
		'created_at' => date('Y-m-d H:i:s'),
		'updated_at' => date('Y-m-d H:i:s'),
	];
}

function render($action)
{
    $filename = 'views/'.$action.'.php';
    if (!file_exists($filename)) {
        $filename = 'views/'.Config::get('DEFAULT_VIEW').'.php';
    }

    $useLayout = !in_array($action, Config::get('NO_LAYOUT_VIEWS'));
    $currentUser = currentUser();

    include ROOT_PATH.'/middleware.php';

    if ($useLayout) {
        include ROOT_PATH.'/views/layout.top.php';
    }

    include ROOT_PATH.'/'.$filename;

    if ($useLayout) {
        include ROOT_PATH.'/views/layout.bottom.php';
    }
}

function isPostMethod()
{
	return strtolower($_SERVER['REQUEST_METHOD']) == 'post';
}

function isEmail($text)
{
	return preg_match('/^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/', $text);
}

function isLogined()
{
	return isset($_SESSION['u_id'])
		&& intval($_SESSION['u_id']) > 0
		&& isset($_SESSION['u_token'])
		&& strlen($_SESSION['u_token']) == 32;
}

function isAdmin()
{
	if (!isset($_SESSION['u_id'])) {
		return false;
	}

	$admin = User::findAdmin();
	return $admin && $admin['id'] === $_SESSION['u_id'];
}

function currentUser()
{
	$id = (int) arrayFind($_SESSION, 'u_id');
	return User::find($id);
}
