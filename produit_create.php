<?php
require_once 'database.php';
session_start();

$product = [];
$message = "";

if (isset($_SESSION['user_id']) && isset($_SESSION['user_login'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $type_p = trim($_POST['type_p'] ?? '');
        $designation_p = trim($_POST['designation_p'] ?? '');
        $prix_ht = $_POST['prix_ht'] ?? '';
        $stock_p = $_POST['stock_p'] ?? '';
        $date_in = $_POST['date_in'] ?? '';

        if ($type_p === '' || $designation_p === '' || $prix_ht === '' || $stock_p === '') {
            $message = 'All fields are required.';
        } else {
            $query = "INSERT INTO produit (type_p, designation_p, prix_ht, stock_p, date_in)
                      VALUES (:type_p, :designation_p, :prix_ht, :stock_p, :date_in)";
            $params = [
                ':type_p' => $type_p,
                ':designation_p' => $designation_p,
                ':prix_ht' => $prix_ht,
                ':stock_p' => $stock_p,
                ':date_in' => ($date_in !== '' ? $date_in : null)
            ];

            $statement = $db->prepare($query);
            $statement->execute($params);

            header('Location: produit_list.php');
            exit();
        }
    }
} else {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='UTF-8'>
    <title>Edit Product</title>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
</head>
<body>
<form method="POST" action="">
    <label for="type_p">Type :</label>
    <input type="text" id="type_p" name="type_p" value="" required>
    <br/>

    <label for="designation_p">Designation :</label>
    <input type="text" id="designation_p" name="designation_p" value="" required>
    <br/>

    <label for="prix_ht">Price without taxes :</label>
    <input type="number" step="0.01" id="prix_ht" name="prix_ht" value="" required>
    <br/>

    <label for="stock_p">Stock :</label>
    <input type="number" id="stock_p" name="stock_p" value="" required>
    <br/>

    <label for="date_in">Date :</label>
    <input type="date" id="date_in" name="date_in" value="" required>
    <br/>

    <button type="submit">Create</button>
    <button type="button" onclick="window.location.href='produit_list.php';">Cancel</button>
</form>
</body>
</html>