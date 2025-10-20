<?php
// Charge les variables d'environnement depuis un fichier .env ou .env.local
function loadEnv($path)
{
    if (!file_exists($path)) return;

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Ignorer les commentaires
        if (str_starts_with(trim($line), '#')) continue;

        // Séparer clé/valeur
        [$name, $value] = array_map('trim', explode('=', $line, 2));
        if (!array_key_exists($name, $_ENV)) {
            putenv("$name=$value");
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}

// Charger .env puis .env.local
loadEnv('.env.local');
loadEnv('.env');
