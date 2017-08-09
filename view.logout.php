<?php
defined('VERSION') or die('deny access');

signLogout();
setFlashMessage('您的账号已正常退出');
redirect(url());
