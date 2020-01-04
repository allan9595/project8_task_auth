<?php
function isAuth(){
    global $session;
    return $session->get('auth_logged_in', false);
}

function requireAuth(){
    if(!isAuth()){
        global $session;
        $session->getFlashBag()->add('error', 'Not Authorized');
        redirect('/login.php');
    }
}

function saveUserSession($user){
    global $session;
    $session->set('auth_logged_in', true);
    $session->set('auth_user_id', (int) $user['id']);
    $session->getFlashBag()->add('success', 'You are successfully logged in!');
}

function getAuthUser(){
    global $session;
    return findUserById($session->get('auth_user_id'));
}
?>