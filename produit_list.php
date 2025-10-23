<?php
require_once 'database.php';
session_start();

$products = [];

if (isset($_SESSION['user_id']) && isset($_SESSION['user_login'])) {
    $query = "SELECT id_p, type_p, designation_p, prix_ht, stock_p, date_in, timeS_in
                FROM produit";
    $statement = $db->query($query);
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);
} else {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='UTF-8'>
    <title>Product List</title>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
</head>
<body>
    <button onclick="window.location.href='produit_create.php';" type="button">➕ Add new product</button>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Designation</th>
            <th>Price without taxes</th>
            <th>Stock</th>
            <th>Date</th>
            <th>Created (timestamp)</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $p): ?>
            <tr>
                <td><?= $p['id_p'] ?></td>
                <td><?= htmlspecialchars($p['type_p']) ?></td>
                <td><?= htmlspecialchars($p['designation_p']) ?></td>
                <td><?= htmlspecialchars($p['prix_ht']) ?></td>
                <td><?= htmlspecialchars($p['stock_p']) ?></td>
                <td><?= htmlspecialchars($p['date_in']) ?></td>
                <td><?= htmlspecialchars($p['timeS_in']) ?></td>
                <td>
                    <a href="produit_edit.php?id=<?= $p['id_p'] ?>">✏️ Edit</a>
                    <a href="produit_delete.php?id=<?= $p['id_p'] ?>">🗑️ Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <button onclick="window.location.href='index.php';" type="button">Go back</button>
</body>
</html>