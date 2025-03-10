<?php
require_once '../konfiguracja/config.php';

$email = 'admin@alekino.pl';
$password = 'admin123';
$haslo = password_hash($password, PASSWORD_DEFAULT);

$stmt = $db->prepare("DELETE FROM pracownicy WHERE email = ?");
$stmt->execute([$email]);


$stmt = $db->prepare("INSERT INTO pracownicy (imie, nazwisko, email, haslo, stanowisko) VALUES (?, ?, ?, ?, ?)");
$stmt->execute(['Admin', 'System', $email, $haslo, 'admin']);

echo "Sukces";
?>

LOGIN: admin@alekino.pl
HASŁO: admin123
Wymagane!