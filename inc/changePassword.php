<?php
require_once "bootstrap.php";

requireAuth();
$currentPassword = request()->get('current_password');
$newPassword = request()->get('password');
$confirmPassword = request()->get('confirm_password');

if($newPassword != $confirmPassword){
    $session->getFlashBag()->add('error', 'New passwords do not match. Please try again.');
    redirect('/account.php');
}

$user = getAuthUser();

if(empty($user)){
    $session->getFlashBag()->add('error', 'Some Error Happened, Please Try Again. If it continues, please log out and back in.');
    redirect('/account.php');
}

if(!password_verify($currentPassword, $user['password'])){
    $session->getFlashBag()->add('error', 'Current password was incorrect, please try again.');
    redirect('/account.php');
}
//password validation

if( strlen($newPassword ) < 10 ) {
    $session->getFlashBag()->add('error','Password too short, at least 10 characters!');
    redirect('/account.php');
}else if( strlen(newPassword ) > 30 ) {
    $session->getFlashBag()->add('error','Password can not exceeding 30 characters!');
    redirect('/account.php');
}else if( !preg_match("#[0-9]+#", $newPassword ) ) {
    $session->getFlashBag()->add('error','Password must include at least one number!');
    redirect('/account.php');
}else if( !preg_match("#[a-z]+#", $newPassword ) ) {
    $session->getFlashBag()->add('error','Password must include at least one letter!');
    redirect('/account.php');
}else if( !preg_match("#[A-Z]+#", $newPassword ) ) {
    $session->getFlashBag()->add('error','Password must include at least one CAPS!');
    redirect('/account.php');
}else if( !preg_match("#\W+#", $newPassword ) ) {
    $session->getFlashBag()->add('error','Password must include at least one symbol!');
    redirect('/account.php');
}else{
    $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
    if(!updatePassword($hashed, $user['id'])){
        $session->getFlashBag()->add('error', 'Could not update password, please try again.');
        redirect('/account.php');
    };

    $session->getFlashBag()->add('success', 'Password Updated');
    redirect('/account.php');
}

?>