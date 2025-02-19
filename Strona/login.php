<?php
require_once 'config.php';

session_start();

if (isset($_SESSION['user_id'])) {
    header(header: 'Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim(string: $_POST['email']);
    $telefon = trim(string: $_POST['telefon']);
    
    $stmt = $db->prepare(query: "SELECT klient_id, imie, nazwisko FROM klienci WHERE email = ? AND telefon = ?");
    $stmt->execute(params: [$email, $telefon]);
    $user = $stmt->fetch(mode: PDO::FETCH_ASSOC);
    
    if ($user) {
        $_SESSION['user_id'] = $user['klient_id'];
        $_SESSION['user_name'] = $user['imie'] . ' ' . $user['nazwisko'];
        header(header: 'Location: index.php');
        exit();
    } else {
        $error = "Nieprawidłowy email lub telefon";
    }
}
?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie - Alekino</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="images/png" sizes="64x64" href="zdjecia/logo/logo.png">
</head>
<body>
    <main class="login-container">
        <h2>Logowanie</h2>
        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form class="login-form" method="POST" action="">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="telefon">Telefon</label>
                <input type="tel" id="telefon" name="telefon" pattern="[0-9]{9}" required>
            </div>
            
            <button type="submit">Zaloguj się</button>
            
            <div class="register-link">
                Nie masz konta? <a href="rejestracja.php">Zarejestruj się</a>
            </div>
        </form>
    </main>
</body>
</html>
