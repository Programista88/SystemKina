<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imie = trim($_POST['imie']);
    $nazwisko = trim($_POST['nazwisko']);
    $email = trim($_POST['email']);
    $telefon = trim($_POST['telefon']);

    $check_email = $db->prepare("SELECT klient_id FROM klienci WHERE email = ?");
    $check_email->execute([$email]);

    if ($check_email->rowCount() > 0) {
        $error = "Ten email jest już zarejestrowany";
    } else {
        $stmt = $db->prepare("INSERT INTO klienci (imie, nazwisko, email, telefon) VALUES (?, ?, ?, ?)");
        try {
            $stmt->execute([$imie, $nazwisko, $email, $telefon]);
            header('Location: login.php?registered=true');
            exit();
        } catch(PDOException $e) {
            $error = "Błąd podczas rejestracji";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja - Alekino</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="images/png" sizes="64x64" href="zdjecia/logo/logo.png">
</head>

<body>
    <main class="register-container">
        <h2>Rejestracja</h2>
        <form class="register-form" method="POST" action="">
            <div class="form-group">
                <label for="imie">Imię</label>
                <input type="text" id="imie" name="imie" required>
            </div>

            <div class="form-group">
                <label for="nazwisko">Nazwisko</label>
                <input type="text" id="nazwisko" name="nazwisko" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="telefon">Telefon</label>
                <input type="tel" id="telefon" name="telefon" pattern="[0-9]{9}" required>
            </div>

            <button type="submit">Zarejestruj się</button>
        </form>
    </main>
</body>

</html>