<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Welcome</title>
    </head>
    <body>
        <?php
            session_start();

            if (!isset($_SESSION['user_id'])) {
                header('Location: register.php');
                exit();
            } else {
                echo "<h1>Welcome to this incredible website, " . htmlspecialchars($_SESSION['user_login']) . " !</h1>";
            }
        ?>
        <button onclick="window.location.href='logout.php';" type="button">Logout</button>
    </body>
</html>