<?php
session_start();
require_once 'config.php';

// Only admin access
if (!isset($_SESSION['pracownik_id']) || $_SESSION['pracownik_stanowisko'] !== 'admin') {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $email = $_POST['email'];
    $haslo = password_hash($_POST['haslo'], PASSWORD_DEFAULT);
    $stanowisko = $_POST['stanowisko'];
    
    $stmt = $db->prepare("INSERT INTO pracownicy (imie, nazwisko, email, haslo, stanowisko) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$imie, $nazwisko, $email, $haslo, $stanowisko]);
}
