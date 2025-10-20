<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
    </head>
    <body>
        <?php
            require_once 'database.php';
            session_start(); 

            $message = "";

            if (isset($_POST['login_submit'])) {
                $login = $_POST['login'];
                $password = $_POST['password'];

                if (empty($login) || empty($password)) {
                    die("Both fields are required.");
                }

                $query = "SELECT * FROM users WHERE login = :login";
                $statement = $db->prepare($query);
                $statement->execute([':login' => $login]);
                $user = $statement->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_login'] = $user['login'];
                    header('Location: index.php');
                    exit();
                } else {
                    $message = "Invalid login or password.";
                }
            }
        ?>
        <h1>Login</h1>
        <h2><?php echo $message; ?></h2>
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