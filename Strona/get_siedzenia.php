<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$seans_id = $_GET['seans_id'] ?? null;

if ($seans_id) {
    try {
        $stmt = $db->prepare("
            SELECT m.miejsce_id, m.numer_rzedu, m.numer_miejsca,
                   CASE WHEN r.rezerwacja_id IS NOT NULL THEN 1 ELSE 0 END as zajete
            FROM seanse s
            JOIN sale sa ON s.sala_id = sa.sala_id
            JOIN miejsca m ON sa.sala_id = m.sala_id
            LEFT JOIN rezerwacje r ON m.miejsce_id = r.miejsce_id 
                AND r.seans_id = ? AND r.status = 'aktywna'
            WHERE s.seans_id = ?
            ORDER BY m.numer_rzedu, m.numer_miejsca
        ");
        
        $stmt->execute([$seans_id, $seans_id]);
        $miejsca = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        header('Content-Type: application/json');
        echo json_encode($miejsca);
    } catch (PDOException $e) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Database error']);
    }
}
