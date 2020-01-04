<?php
//task functions

function getTasks($where = null, $userId = null)
{
    $userId = filter_var($userId, FILTER_SANITIZE_NUMBER_INT);
    global $db;
    $query = "SELECT * FROM tasks ";
    if (!empty($where)){
        $query .= "WHERE $where AND user_id = $userId ORDER BY id";
    }else{
        $query .= "WHERE user_id = $userId ORDER BY id";
    }
    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $tasks = $statement->fetchAll();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return $tasks;
}
function getIncompleteTasks()
{
    global $session;
    return getTasks('status=0',decodeAuthCookie('auth_user_id'));
}
function getCompleteTasks()
{
    global $session;
    return getTasks('status=1',decodeAuthCookie('auth_user_id'));
}
function getTask($task_id)
{
    global $db;

    try {
        $statement = $db->prepare('SELECT id, task, status FROM tasks WHERE id=:id');
        $statement->bindParam('id', $task_id);
        $statement->execute();
        $task = $statement->fetch();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return $task;
}
function createTask($data, $userId)
{
    global $db;
    $task = filter_var($data['task'], FILTER_SANITIZE_STRING);
    $status = filter_var($data['status'], FILTER_SANITIZE_NUMBER_INT);
    $userId = filter_var($userId, FILTER_SANITIZE_NUMBER_INT);
    try {
        $statement = $db->prepare('
            INSERT INTO tasks (task, status, user_id) VALUES (?, ?, ?)'
        );
        $statement->bindValue(1, $task, PDO::PARAM_STR);
        $statement->bindValue(2, $status, PDO::PARAM_INT);
        $statement->bindValue(3, $userId, PDO::PARAM_INT);
        $statement->execute();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return getTask($db->lastInsertId());
}
function updateTask($data, $userId)
{
    global $db;
    $userId = filter_var($userId, FILTER_SANITIZE_NUMBER_INT);
    try {
        getTask($data['task_id']);
        $statement = $db->prepare('
            UPDATE tasks SET task=:task, status=:status WHERE id=:id AND user_id = :userId
        ');
        $statement->bindParam('task', $data['task']);
        $statement->bindParam('status', $data['status']);
        $statement->bindParam('id', $data['task_id']);
        $statement->bindParam('userId', $userId);
        $statement->execute();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return getTask($data['task_id']);
}
function updateStatus($data, $userId)
{
    global $db;
    $userId = filter_var($userId, FILTER_SANITIZE_NUMBER_INT);
    try {
        getTask($data['task_id']);
        $statement = $db->prepare('
            UPDATE tasks SET status=:status WHERE id=:id AND user_id = :userId
        ');
        $statement->bindParam('status', $data['status']);
        $statement->bindParam('id', $data['task_id']);
        $statement->bindParam('userId', $userId);
        $statement->execute();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return getTask($data['task_id']);
}
function deleteTask($task_id, $userId)
{
    global $db;
    $userId = filter_var($userId, FILTER_SANITIZE_NUMBER_INT);
    try {
        getTask($task_id);
        $statement = $db->prepare('
            DELETE FROM tasks WHERE id=:id AND user_id = :userId
        ');
        $statement->bindParam('id', $task_id);
        $statement->bindParam('userId', $userId);
        $statement->execute();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return true;
}
