<?php

// Filtres
$query = $_GET['q'] ?? '';

// Pagination
$limit = 20;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// Requête SQL principale
$sql = "SELECT * FROM evenements WHERE 1=1";
$params = [];

// Filtres dynamiques
if (!empty($query)) {
  $sql .= " AND (titre LIKE :q OR description LIKE :q)";
  $params[':q'] = '%' . $query . '%';
}

// Compter le total d'événements
$count_sql = "SELECT COUNT(*) FROM evenements WHERE 1=1";
$count_stmt = $pdo->prepare(str_replace("SELECT *", "SELECT COUNT(*)", $sql));
$count_stmt->execute($params);
$total_events = $count_stmt->fetchColumn();
$total_pages = ceil($total_events / $limit);

// Ajouter LIMIT & OFFSET
$sql .= " ORDER BY date_debut DESC LIMIT :limit OFFSET :offset";

$stmt = $pdo->prepare($sql);
foreach ($params as $key => $value) {
  $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
}
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$events = $stmt->fetchAll();

?>