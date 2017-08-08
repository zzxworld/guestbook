<?php
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

function render($action, $useLayout = true)
{
    $filename = 'view.'.$action.'.php';
    if (!file_exists($filename)) {
        $filename = 'view.'.Config::get('DEFAULT_VIEW').'.php';
    }

    if ($useLayout) {
        include 'view.layout.top.php';
    }

    $content = include $filename;

    if ($useLayout) {
        include 'view.layout.bottom.php';
    }
}
