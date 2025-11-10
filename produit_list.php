<?php
session_start();
require_once 'database.php'; // Connexion PDO ($db)

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Récupère le filtre depuis l'URL
$typeFilter = $_GET['type'] ?? '';

// Prépare la requête avec ou sans filtre
if (!empty($typeFilter)) {
    $stmt = $db->prepare("
        SELECT id_p, type_p, designation_p, prix_ht, stock_p, date_in, timeS_in
        FROM produit
        WHERE type_p = :type
        ORDER BY id_p ASC
    ");
    $stmt->bindParam(':type', $typeFilter, PDO::PARAM_STR);
} else {
    $stmt = $db->prepare("
        SELECT id_p, type_p, designation_p, prix_ht, stock_p, date_in, timeS_in
        FROM produit
        ORDER BY id_p ASC
    ");
}

$stmt->execute();
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupère la liste distincte des types pour le menu déroulant
$types = $db->query("SELECT DISTINCT type_p FROM produit ORDER BY type_p ASC")->fetchAll(PDO::FETCH_COLUMN);
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
        <div class="card-header" style="flex-wrap: wrap;">
            <div>
                <h1 class="card-title">Produits</h1>
                <p class="card-subtitle">
                    Liste complète des produits enregistrés dans la base de données.
                </p>
            </div>

            <div style="display:flex; gap:0.75rem; flex-wrap:wrap; align-items:center;">
                <!-- Menu de tri -->
                <form method="GET" action="produit_list.php" style="display:flex; align-items:center; gap:0.5rem;">
                    <label for="type" style="font-size:0.9rem;">Trier par type :</label>
                    <select name="type" id="type" onchange="this.form.submit()" style="border-radius:999px; padding:0.35rem 0.8rem;">
                        <option value="">Tous les types</option>
                        <?php foreach ($types as $type): ?>
                            <option value="<?php echo htmlspecialchars($type); ?>"
                                <?php if ($type === $typeFilter) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($type); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>

                <button
                        type="button"
                        class="btn btn-primary"
                        onclick="window.location.href='produit_create.php';"
                >
                    ➕ Ajouter un produit
                </button>
            </div>
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
                            Aucun produit trouvé<?php if (!empty($typeFilter)) echo " pour le type <strong>" . htmlspecialchars($typeFilter) . "</strong>"; ?>.
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
