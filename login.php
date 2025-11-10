<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
</head>
<body class="auth-body">

<div class="card auth-card">
    <div class="auth-header">
        <h1 class="auth-title">Welcome back 👋</h1>
        <p class="auth-subtitle">
            Connecte-toi pour accéder au back-office CRUD.
        </p>
    </div>

    <?php if (!empty($message)): ?>
        <div class="alert alert-error">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-grid">
            <div class="form-group">
                <label for="login">Login</label>
                <input
                        id="login"
                        name="login"
                        type="text"
                        placeholder="Type your login..."
                        required
                />
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Type your password..."
                        required
                />
            </div>
        </div>

        <div style="margin-top: 1.5rem; display:flex; gap:0.75rem; justify-content:space-between; align-items:center; flex-wrap:wrap;">
            <button type="submit" name="login_submit" class="btn btn-primary">
                ➜ Login
            </button>

            <button
                    type="button"
                    class="btn btn-secondary"
                    onclick="window.location.href='register.php';"
            >
                I don't have an account
            </button>
        </div>
    </form>

    <div class="auth-footer">
        <span>Besoin d’un compte admin ?</span><br>
        <span>Contacte l’administrateur de l’application.</span>
    </div>
</div>

</body>
</html>
