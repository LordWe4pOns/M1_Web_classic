<?php
session_start();

// Vérifie la connexion
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_login = $_SESSION['user_login'] ?? 'Utilisateur';
$is_admin = $_SESSION['admin'] ?? 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="main.css">
</head>
<body class="main-body">

<header class="topbar">
    <div class="topbar-title">
        <span class="logo-dot"></span>
        <span>CRUD Dashboard</span>
    </div>
    <div class="topbar-actions">
        <button class="btn btn-ghost" onclick="window.location.href='logout.php';">
            ⏻ Déconnexion
        </button>
    </div>
</header>

<main class="container">
    <div class="card" style="text-align:center;">
        <h1 class="card-title">Bienvenue, <?php echo htmlspecialchars($user_login); ?> 👋</h1>
        <p class="card-subtitle" style="margin-bottom:2rem;">
            Bienvenue sur le tableau de bord de gestion du CRUD.<br>
            Sélectionne une section ci-dessous pour continuer.
        </p>

        <div style="display:flex; flex-wrap:wrap; justify-content:center; gap:1.5rem;">
            <?php if ($is_admin == 1): ?>
                <button
                        class="btn btn-primary"
                        onclick="window.location.href='user_list.php';"
                >
                    👤 Liste des utilisateurs
                </button>
            <?php endif; ?>

            <button
                    class="btn btn-primary"
                    onclick="window.location.href='produit_list.php';"
            >
                📦 Liste des produits
            </button>

            <button
                    class="btn btn-secondary"
                    onclick="window.location.href='logout.php';"
            >
                ⏻ Déconnexion
            </button>
        </div>
    </div>
</main>

<footer style="text-align:center; margin-top:2rem; color:#94a3b8; font-size:0.85rem;">
    <p>&copy; <?php echo date('Y'); ?> — CRUD Project by <strong>Thibaut | Simon | Clément | Mathieu | Abdoul</strong></p>
</footer>

</body>
</html>
