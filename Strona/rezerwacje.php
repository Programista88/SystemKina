<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $film_id = $_POST['film_id'] ?? null;
    $seans_id = $_POST['seans_id'] ?? null;
    $miejsce_id = $_POST['miejsce_id'] ?? null;
    $klient_id = $_POST['klient_id'] ?? null;

    if ($film_id && $seans_id && $miejsce_id && $klient_id) {
        try {
            $stmt = $db->prepare(query: "INSERT INTO rezerwacje (klient_id, seans_id, miejsce_id) VALUES (?, ?, ?)");
            $stmt->execute(params: [$klient_id, $seans_id, $miejsce_id]);
            echo json_encode(value: ['success' => true, 'message' => 'Rezerwacja została utworzona']);
        } catch(PDOException $e) {
            echo json_encode(value: ['success' => false, 'message' => 'Błąd podczas rezerwacji']);
        }
    }
}
?>
