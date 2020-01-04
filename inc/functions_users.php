<?php

function findUserByUsername($username){
    global $db;
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    try{
        $sql = "
            SELECT * FROM users WHERE username = ?
        ";
        $pdo = $db->prepare($sql);
        $pdo->bindValue(1, $username, PDO::PARAM_STR);
        $pdo->execute();
        return $pdo->fetch();
    }catch(Exception $e){
        throw $e;
    }
}

function findUserById($id){
    global $db;
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    try{
        $sql = "
            SELECT * FROM users WHERE id = ?
        ";
        $pdo = $db->prepare($sql);
        $pdo->bindValue(1, $id, PDO::PARAM_INT);
        $pdo->execute();
        return $pdo->fetch();
    }catch(Exception $e){
        throw $e;
    }
}

function createUser($username, $password){
    global $db;
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $password = filter_var($password, FILTER_SANITIZE_STRING);
    try{
        $sql = "
            INSERT INTO users (username, password) VALUES (?, ?);
        ";
        $pdo = $db->prepare($sql);
        $pdo->bindValue(1, $username, PDO::PARAM_STR);
        $pdo->bindValue(2, $password, PDO::PARAM_STR);
        $pdo->execute();
        return findUserByUsername($username);
    }catch(Execption $e){
        throw $e;
    }
}

function updatePassword($password, $id){
    global $db;
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    $password = filter_var($password, FILTER_SANITIZE_STRING);
    try{
        $sql = "
            UPDATE users SET password = ? WHERE id = ? 
        ";
        $pdo = $db->prepare($sql);
        $pdo->bindValue(1, $password, PDO::PARAM_STR);
        $pdo->bindValue(2, $id, PDO::PARAM_INT);
        $pdo->execute();
        if($pdo->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }catch(Exception $e){
        throw $e;
    }
    return true;
}
?>