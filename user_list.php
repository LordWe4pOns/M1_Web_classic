<?php 
    require_once 'database.php';
    session_start(); 

    $users = [];

    if (isset($_SESSION['user_id']) && isset($_SESSION['user_login'])) {
        $query = "SELECT user_id, user_login, user_mail, user_date_new, user_date_login
                FROM user";
        $statement = $db->query($query);
        $users = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    else {
        header('Location: login.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset='UTF-8'>
        <title>User List</title>
        <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Login</th>
                    <th>Email</th>
                    <th>Created</th>
                    <th>Last connection</th>
                    <?php if ($_SESSION['admin'] == 1): ?>
                        <th>Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= $u['user_id'] ?></td>
                        <td><?= htmlspecialchars($u['user_login']) ?></td>
                        <td><?= htmlspecialchars($u['user_mail']) ?></td>
                        <td><?= htmlspecialchars($u['user_date_new']) ?></td>
                        <td><?= htmlspecialchars($u['user_date_login']) ?></td>
                        <?php
                        // si _SESSION['admin'] est défini et vaut 1, afficher les actions
                        if ($_SESSION['admin'] == 1):
                        ?>
                        <td>
                            <a href="user_edit.php?id=<?= $u['user_id'] ?>">✏️ Edit</a>
                            <a href="user_delete.php?id=<?= $u['user_id'] ?>">🗑️ Delete</a>
                        </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button onclick="window.location.href='index.php';" type="button">Go back</button>
    </body>
</html>