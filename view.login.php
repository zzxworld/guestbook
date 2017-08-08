<?php
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

$adminUsers = Config::get('ADMIN_USERS');
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
