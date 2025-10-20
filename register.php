<?php
session_start();
require_once 'database.php';

$message = "";

if (isset($_POST['register'])) {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';
    $account_id = $_POST['account_id'] ?? '';
    $email = $_POST['email'] ?? '';

    if ($login === '' || $password === '' || $account_id === '' || $email === '') {
        $message = "All fields are required.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO user (user_login, user_password, user_compte_id, user_mail) VALUES (:login, :password, :account_id, :email)";
        $statement = $db->prepare($query);
        $statement->execute([
            ':login' => $login,
            ':password' => $hashedPassword,
            ':account_id' => $account_id,
            ':email' => $email
        ]);

        if ($statement->rowCount()) {
            header('Location: login.php');
            exit();
        } else {
            $message = "Registration failed. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Register</title>
    </head>
    <body>
        <h1>Register</h1>
        <h2><?php echo htmlspecialchars($message); ?></h2>
        <form method="POST" action="">
            <label for="login">Login</label>
            <input id="login" name="login" type="text" placeholder="Type your login..." required />
            <br/>

            <label for="password">Password</label>
            <input id="password" name="password" type="password" placeholder="Type your password..." required />
            <br/>

            <label for="account_id">Account ID</label>
            <input id="account_id" name="account_id" type="number" placeholder="Type your account ID..." required />
            <br/>

            <label for="email">Email address</label>
            <input id="email" name="email" type="email" placeholder="Type your email address..." required />
            <br/>

            <input type="submit" value="Register" name="register">
            <button onclick="window.location.href='login.php';" type="button">I already have an account</button>
        </form>
    </body>
</html>