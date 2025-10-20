<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: register.php');
    exit();
}

$user_login = $_SESSION['user_login'] ?? 'User';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Welcome</title>
    </head>
    <body>
        <h1>Welcome to this incredible website, <?php echo htmlspecialchars($user_login); ?> !</h1>
        <button onclick="window.location.href='user_list.php';" type="button">User List</button>
        <button onclick="window.location.href='logout.php';" type="button">Logout</button>
    </body>
</html>