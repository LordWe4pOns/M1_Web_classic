<?php 
    require_once 'database.php';
    session_start(); 

    $user = [];
    $message = "";

    if (isset($_SESSION['user_id']) && isset($_SESSION['user_login']) && isset($_GET['id'])) {
        $id = $_GET['id'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'] ?? '';
            $password = $_POST['password'] ?? '';
            $account_id = $_POST['account_id'] ?? '';
            $email = $_POST['email'] ?? '';

            $query = "";
            $params = [];

            if (!empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $query = "UPDATE user
                        SET user_login = :login, user_password = :password, user_compte_id = :account_id, user_mail = :email
                        WHERE user_id = :id";
                $params = [
                    ':login' => $login,
                    ':password' => $hashedPassword,
                    ':account_id' => $account_id,
                    ':email' => $email,
                    ':id' => $id
                ];
            }
            else {
                $query = "UPDATE user
                        SET user_login = :login, user_compte_id = :account_id, user_mail = :email
                        WHERE user_id = :id";
                $params = [
                    ':login' => $login,
                    ':account_id' => $account_id,
                    ':email' => $email,
                    ':id' => $id
                ];
            }

            $statement = $db->prepare($query);
            $statement->execute($params);

            header('Location: user_list.php');
            exit();
        }
        else {
            $query = "SELECT user_id, user_login, user_compte_id, user_mail
                    FROM user
                    WHERE user_id = :id";
            $statement = $db->prepare($query);
            $statement->execute([':id' => $id]);
            $user = $statement->fetch(PDO::FETCH_ASSOC);
        }
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
        <title>Edit User</title>
        <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    </head>
    <body>
        <form method="POST" action="">
        <label for="login">Login :</label>
        <input type="text" id="login" name="login" value="<?= htmlspecialchars($user['user_login']) ?>" required>
        <br/><br/>

        <label for="password">New password :</label>
        <input type="password" id="password" name="password" placeholder="********">
        <br/><br/>

        <label for="account_id">Account ID :</label>
        <input type="number" id="account_id" name="account_id" value="<?= htmlspecialchars($user['user_compte_id']) ?>" required>
        <br/><br/>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['user_mail']) ?>" required>
        <br/><br/>

        <button type="submit">Update</button>
        <button type="button" onclick="window.location.href='user_list.php';">Cancel</button>
    </form>
    </body>
</html>