<?php
require_once 'database.php';
session_start();

$product = [];
$message = "";

if (isset($_SESSION['user_id']) && isset($_SESSION['user_login']) && isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $type_p = trim($_POST['type_p'] ?? '');
        $designation_p = trim($_POST['designation_p'] ?? '');
        $prix_ht = $_POST['prix_ht'] ?? '';
        $stock_p = $_POST['stock_p'] ?? '';
        $date_in = $_POST['date_in'] ?? '';

        if ($type_p === '' || $designation_p === '' || $prix_ht === '' || $stock_p === '') {
            $message = 'Tous les champs (sauf date) sont obligatoires.';
        } else {
            $query = "UPDATE produit
                        SET type_p = :type_p,
                            designation_p = :designation_p,
                            prix_ht = :prix_ht,
                            stock_p = :stock_p,
                            date_in = :date_in
                      WHERE id_p = :id";
            $params = [
                ':type_p' => $type_p,
                ':designation_p' => $designation_p,
                ':prix_ht' => $prix_ht,
                ':stock_p' => $stock_p,
                ':date_in' => ($date_in !== '' ? $date_in : null),
                ':id' => $id
            ];

            $statement = $db->prepare($query);
            $statement->execute($params);

            header('Location: produit_list.php');
            exit();
        }
    } else {
        $query = "SELECT id_p, type_p, designation_p, prix_ht, stock_p, date_in, timeS_in
                    FROM produit
                   WHERE id_p = :id";
        $statement = $db->prepare($query);
        $statement->execute([':id' => $id]);
        $product = $statement->fetch(PDO::FETCH_ASSOC);
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
    <input type="text" id="type_p" name="type_p" value="<?= htmlspecialchars($product['type_p'] ?? '') ?>" required>
    <br/><br/>

    <label for="designation_p">Désignation :</label>
    <input type="text" id="designation_p" name="designation_p" value="<?= htmlspecialchars($product['designation_p'] ?? '') ?>" required>
    <br/><br/>

    <label for="prix_ht">Prix HT :</label>
    <input type="number" step="0.01" id="prix_ht" name="prix_ht" value="<?= htmlspecialchars((string)($product['prix_ht'] ?? '')) ?>" required>
    <br/><br/>

    <label for="stock_p">Stock :</label>
    <input type="number" id="stock_p" name="stock_p" value="<?= htmlspecialchars((string)($product['stock_p'] ?? '')) ?>" required>
    <br/><br/>

    <label for="date_in">Date d'entrée (optionnelle) :</label>
    <input type="date" id="date_in" name="date_in" value="<?= htmlspecialchars($product['date_in'] ?? '') ?>">
    <br/><br/>

    <label for="timeS_in">Horodatage (lecture seule) :</label>
    <input type="text" id="timeS_in" value="<?= htmlspecialchars($product['timeS_in'] ?? '') ?>" readonly>
    <br/><br/>

    <button type="submit">Update</button>
    <button type="button" onclick="window.location.href='produit_list.php';">Cancel</button>
</form>
</body>
</html>