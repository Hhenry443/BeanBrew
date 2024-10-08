<?php
require '../helpers.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

session_unset();
session_destroy();

$params = session_get_cookie_params();
setcookie('PHPSESSID', '', time() - 86400, $params['path'], $params['domain']);

redirect('/');
