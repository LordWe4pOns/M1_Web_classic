<?php 
    require_once 'database.php';
    session_start(); 

    $user = [];

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "DELETE FROM user WHERE user_id = :id";
        $statement = $db->prepare($query);
        $statement->execute([':id' => $id]);
    }

    header('Location: user_list.php');
    exit();