<?php
session_start();

$query = $_GET['q'] ?? '';

if (empty($query)) {
    $_SESSION['error'] = "Veuillez entrer un mot-clé.";
    header("Location: ../index.php");
    exit;
}

$encodedQuery = urlencode($query);
$apiUrl = "https://opendata.paris.fr/api/v2/catalog/datasets/que-faire-a-paris-/records?limit=20&search={$encodedQuery}";

$response = file_get_contents($apiUrl);

if ($response === false) {
    $_SESSION['error'] = "Erreur lors de la connexion à l’API.";
    header("Location: ../index.php");
    exit;
}

$data = json_decode($response, true);
$_SESSION['recherche_results'] = $data['records'] ?? [];
$_SESSION['recherche_query'] = $query;

header("Location: ../vue/recherche.php");
exit;
