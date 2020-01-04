<?php
require_once "bootstrap.php";

$session->remove('auth_logged_in');
$session->remove('auth_user_id');

$session->getFlashBag()->add('success', 'You are successfully logged out!');
redirect('/login.php');
?>