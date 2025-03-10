<?php
session_start();
require_once '../konfiguracja/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $stmt = $db->prepare("SELECT * FROM pracownicy WHERE email = ?");
    $stmt->execute([$email]);
    $pracownik = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($pracownik && password_verify($password, $pracownik['haslo'])) {
        $_SESSION['pracownik_id'] = $pracownik['pracownik_id'];
        $_SESSION['pracownik_imie'] = $pracownik['imie'];
        $_SESSION['pracownik_nazwisko'] = $pracownik['nazwisko'];
        $_SESSION['pracownik_stanowisko'] = $pracownik['stanowisko'];
        $_SESSION['pracownik_email'] = $pracownik['email'];
        
        header('Location: panel_pracownika.php');
        exit();
    } else {
        $_SESSION['message'] = "Nieprawidłowy email lub hasło";
        $_SESSION['message_type'] = "error";
        header('Location: login.php');
        exit();
    }
}
