<?php
session_start();
require_once '../konfiguracja/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../autoryzacja/login.php');
    exit();
}

$rezerwacja_id = $_GET['id'] ?? null;

if ($rezerwacja_id) {
    try {
        $stmt = $db->prepare("UPDATE rezerwacje SET status = 'anulowana' WHERE rezerwacja_id = ? AND klient_id = ?");
        $stmt->execute([$rezerwacja_id, $_SESSION['user_id']]);
        
        $_SESSION['message'] = 'Rezerwacja została anulowana pomyślnie';
        $_SESSION['message_type'] = 'success';
    } catch (PDOException $e) {
        $_SESSION['message'] = 'Wystąpił błąd podczas anulowania rezerwacji';
        $_SESSION['message_type'] = 'error';
    }
}

header('Location: rezerwacje.php');
exit();
