<?php
session_start();
require_once 'database.php'; // Connexion PDO ($db) déjà configurée ici

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Requête pour récupérer la liste des utilisateurs
$stmt = $db->prepare("
    SELECT 
        user_id, 
        user_login, 
        user_mail, 
        user_date_new, 
        user_date_login, 
        admin
    FROM user
    ORDER BY user_id ASC
");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des utilisateurs</title>
    <link rel="stylesheet" href="main.css">
</head>
<body class="main-body">

<header class="topbar">
    <div class="topbar-title">
        <span class="logo-dot"></span>
        <span>CRUD Dashboard</span>
    </div>
    <div class="topbar-actions">
        <button class="btn btn-ghost" onclick="window.location.href='index.php';">
            ⬅ Accueil
        </button>
        <button class="btn btn-ghost" onclick="window.location.href='logout.php';">
            ⏻ Déconnexion
        </button>
    </div>
</header>

<main class="container">
    <div class="card">
        <div class="card-header">
            <div>
                <h1 class="card-title">Utilisateurs</h1>
                <p class="card-subtitle">
                    Gestion des comptes utilisateurs et de leurs dernières connexions.
                </p>
            </div>

            <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1): ?>
                <button
                        type="button"
                        class="btn btn-primary"
                        onclick="window.location.href='register.php';"
                >
                    ➕ Nouvel utilisateur
                </button>
            <?php endif; ?>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Login</th>
                    <th>Email</th>
                    <th>Date de création</th>
                    <th>Dernière connexion</th>
                    <th>Admin</th>
                    <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1): ?>
                        <th>Actions</th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($u['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($u['user_login']); ?></td>
                            <td><?php echo htmlspecialchars($u['user_mail']); ?></td>
                            <td><?php echo htmlspecialchars($u['user_date_new']); ?></td>
                            <td><?php echo htmlspecialchars($u['user_date_login']); ?></td>
                            <td>
                                <?php echo $u['admin'] == 1 ? '✅ Oui' : '❌ Non'; ?>
                            </td>

                            <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1): ?>
                                <td>
                                    <div class="table-actions">
                                        <a
                                                class="btn btn-secondary"
                                                href="user_edit.php?id=<?php echo $u['user_id']; ?>"
                                        >
                                            ✏️ Modifier
                                        </a>
                                        <a
                                                class="btn btn-danger"
                                                href="user_delete.php?id=<?php echo $u['user_id']; ?>"
                                                onclick="return confirm('Supprimer cet utilisateur ?');"
                                        >
                                            🗑️ Supprimer
                                        </a>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align:center; padding:1rem;">
                            Aucun utilisateur trouvé.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div style="margin-top: 1.25rem; display:flex; justify-content:flex-end;">
            <button
                    type="button"
                    class="btn btn-secondary"
                    onclick="window.location.href='index.php';"
            >
                ⬅ Retour au tableau de bord
            </button>
        </div>
    </div>
</main>

</body>
</html>
