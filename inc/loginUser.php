<?php
require_once "bootstrap.php";

$user = findUserByUsername(request()->get('username'));
if(empty($user)){
    $session->getFlashBag()->add('error', 'Username was not found');
    redirect('/login.php');
}

if(!password_verify(request()->get('password'), $user['password'])){
    $session->getFlashBag()->add('error','Invalid Passowrd');
    redirect('/login.php');
}
saveUserSession($user);
redirect('/');
?>