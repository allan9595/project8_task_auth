<?php
require_once "bootstrap.php";

$username = request()->get('username');
$password = request()->get('password');
$confirmPassword = request()->get('confirm_password');

if($password != $confirmPassword){
    $session->getFlashBag()->add('error', 'Passwords do NOT match');
    redirect('/register.php');
}

$user = findUserByUsername($username);

if(!empty($user)){
    $session->getFlashBag()->add('error','User Already Exists');
    redirect('/register.php');
}

//password validation

if( strlen($password ) < 10 ) {
    $session->getFlashBag()->add('error','Password too short, at least 10 characters!');
    redirect('/register.php');
}else if( strlen($password ) > 30 ) {
    $session->getFlashBag()->add('error','Password can not exceeding 30 characters!');
    redirect('/register.php');
}else if( !preg_match("#[0-9]+#", $password ) ) {
    $session->getFlashBag()->add('error','Password must include at least one number!');
    redirect('/register.php');
}else if( !preg_match("#[a-z]+#", $password ) ) {
    $session->getFlashBag()->add('error','Password must include at least one letter!');
    redirect('/register.php');
}else if( !preg_match("#[A-Z]+#", $password ) ) {
    $session->getFlashBag()->add('error','Password must include at least one CAPS!');
    redirect('/register.php');
}else if( !preg_match("#\W+#", $password ) ) {
    $session->getFlashBag()->add('error','Password must include at least one symbol!');
    redirect('/register.php');
}else{
    //hash the password
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $user = createUser($username, $hashed);
    $session->getFlashBag()->add('success', 'User Added');
    saveUserData($user);
}

?>