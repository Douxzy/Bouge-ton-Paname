<?php
require 'db.php';

$apiUrl = 'https://opendata.paris.fr/api/records/1.0/search/?dataset=que-faire-a-paris-&rows=100';
$response = file_get_contents($apiUrl);

if ($response === FALSE) {
    die('Error while fetching data from the API');
}

$data = json_decode($response, true);

// SQL insert with ON DUPLICATE KEY UPDATE to avoid duplicates
$sql = "INSERT INTO evenements (
            record_id, titre, description, date_debut, date_fin,
            adresse, quartier, prix, accessibilite, cover_url, url
        )
        VALUES (
            :record_id, :titre, :description, :date_debut, :date_fin,
            :adresse, :quartier, :prix, :accessibilite, :cover_url, :url
        )
        ON DUPLICATE KEY UPDATE
            titre = VALUES(titre),
            description = VALUES(description),
            date_debut = VALUES(date_debut),
            date_fin = VALUES(date_fin),
            adresse = VALUES(adresse),
            quartier = VALUES(quartier),
            prix = VALUES(prix),
            accessibilite = VALUES(accessibilite),
            cover_url = VALUES(cover_url),
            url = VALUES(url)";

$stmt = $pdo->prepare($sql);

// Boucle
foreach ($data['records'] as $record) {
    $fields = $record['fields'];

    $record_id = $record['recordid'] ?? null;
    $titre = $fields['title'] ?? '';
    $description = isset($fields['description']) ? strip_tags($fields['description']) : '';
    $date_debut = $fields['date_start'] ?? null;
    $date_fin = $fields['date_end'] ?? null;
    $adresse = $fields['address_street'] ?? '';
    $postalCode = $fields['address_zipcode'] ?? null;
    $prix = $fields['pricing_info'] ?? '';
    $accessibilite = $fields['access_type'] ?? '';
    $url = $fields['url'] ?? '';
    $cover_url = $fields['cover_url'] ?? '';

    $quartier = null;
    if ($postalCode && preg_match('/75(\d{2})/', $postalCode, $match)) {
        $quartier = "Paris " . intval($match[1]) . "e";
    }

    $stmt->execute([
        ':record_id' => $record_id,
        ':titre' => $titre,
        ':description' => $description,
        ':date_debut' => $date_debut,
        ':date_fin' => $date_fin,
        ':adresse' => $adresse,
        ':quartier' => $quartier,
        ':prix' => $prix,
        ':accessibilite' => $accessibilite,
        ':cover_url' => $cover_url,
        ':url' => $url
    ]);
}


echo "Import completed with quartier, price, accessibility and image!";
?>
