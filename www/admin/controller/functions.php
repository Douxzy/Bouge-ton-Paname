<?php
// functions.php

// Récupère les événements depuis la base de données
function getEvents(PDO $pdo)
{
    $sql = "SELECT * FROM evenements ORDER BY date_debut ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



// Récupère un événement par son record_id (lié à l'API Que faire à Paris)
function getEventByRecordId(PDO $pdo, $record_id) {
    $sql = "SELECT * FROM evenements WHERE record_id = :record_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':record_id', $record_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Récupère les commentaires pour un événement spécifique
function getCommentsByEvent(PDO $pdo, $record_id) {
    $sql = "SELECT * FROM commentaires WHERE record_id = :record_id ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':record_id', $record_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
