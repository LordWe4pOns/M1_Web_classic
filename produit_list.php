<?php
session_start();
require_once 'database.php'; // Connexion PDO ($db)

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Requête corrigée selon ta table réelle
$stmt = $db->prepare("
    SELECT 
        id_p,
        type_p,
        designation_p,
        prix_ht,
        stock_p,
        date_in,
        timeS_in
    FROM produit
    ORDER BY id_p ASC
");
$stmt->execute();
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des produits</title>
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
                <h1 class="card-title">Produits</h1>
                <p class="card-subtitle">
                    Liste complète des produits enregistrés dans la base de données.
                </p>
            </div>

            <button
                    type="button"
                    class="btn btn-primary"
                    onclick="window.location.href='produit_create.php';"
            >
                ➕ Ajouter un produit
            </button>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Désignation</th>
                    <th>Prix HT (€)</th>
                    <th>Stock</th>
                    <th>Date</th>
                    <th>Créé le</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($produits)): ?>
                    <?php foreach ($produits as $p): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($p['id_p']); ?></td>
                            <td><?php echo htmlspecialchars($p['type_p']); ?></td>
                            <td><?php echo htmlspecialchars($p['designation_p']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($p['prix_ht'], 2, ',', ' ')); ?></td>
                            <td><?php echo htmlspecialchars($p['stock_p']); ?></td>
                            <td><?php echo htmlspecialchars($p['date_in']); ?></td>
                            <td><?php echo htmlspecialchars($p['timeS_in']); ?></td>
                            <td>
                                <div class="table-actions">
                                    <a
                                            class="btn btn-secondary"
                                            href="produit_edit.php?id=<?php echo $p['id_p']; ?>"
                                    >
                                        ✏️ Modifier
                                    </a>
                                    <a
                                            class="btn btn-danger"
                                            href="produit_delete.php?id=<?php echo $p['id_p']; ?>"
                                            onclick="return confirm('Supprimer ce produit ?');"
                                    >
                                        🗑️ Supprimer
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align:center; padding:1rem;">
                            Aucun produit trouvé.
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
