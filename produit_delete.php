<?php 
    require_once 'database.php';
    session_start(); 

    $user = [];

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "DELETE FROM produit WHERE id_p = :id";
        $statement = $db->prepare($query);
        $statement->execute([':id' => $id]);
    }

    header('Location: produit_list.php');
    exit();