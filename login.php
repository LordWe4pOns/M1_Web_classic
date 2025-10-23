<?php
session_start();
require_once 'database.php';

$message = "";

if (isset($_POST['login_submit'])) {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($login === '' || $password === '') {
        $message = "Both fields are required.";
    } else {
        $query = "SELECT * FROM user WHERE user_login = :login";
        $statement = $db->prepare($query);
        $statement->execute([':login' => $login]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['user_password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_login'] = $user['user_login'];
            $_SESSION['admin'] = $user['admin'];
            header('Location: index.php');
            exit();
        } else {
            $message = "Invalid login or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
    </head>
    <body>
        <h1>Login</h1>
        <h2><?php echo htmlspecialchars($message); ?></h2>
        <form method="POST" action="">
            <label for="login">Login</label>
            <input
                id="login"
                name="login"
                type="text"
                placeholder="Type your login..."
                required
            />
            <br/>

            <label for="password">Password</label>
            <input
                id="password"
                name="password"
                type="password"
                placeholder="Type your password..."
                required
            />
            <br/>

            <input type="submit" value="Login" name="login_submit">
            <button onclick="window.location.href='register.php';" type="button">I don't have an account</button>
        </form>
    </body>
</html>