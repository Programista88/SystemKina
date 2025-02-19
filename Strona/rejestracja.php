<?php
require_once 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imie = trim($_POST['imie']);
    $nazwisko = trim($_POST['nazwisko']);
    $email = trim($_POST['email']);
    $telefon = trim($_POST['telefon']);

    $check_email = $db->prepare("SELECT klient_id FROM klienci WHERE email = ?");
    $check_email->execute([$email]);

    if ($stmt->execute([$imie, $nazwisko, $email, $telefon])) {
        $_SESSION['message'] = "Rejestracja przebiegła pomyślnie!";
        $_SESSION['message_type'] = "success";
        header('Location: login.php');
        exit();
    }
    
    if ($check_email->rowCount() > 0) {
        $error = "Ten email jest już zarejestrowany";
    } else {
        $stmt = $db->prepare("INSERT INTO klienci (imie, nazwisko, email, telefon) VALUES (?, ?, ?, ?)");
        try {
            $stmt->execute([$imie, $nazwisko, $email, $telefon]);
            $_SESSION['registration_success'] = true;
            header('Location: login.php');
            exit();
        } catch(PDOException $e) {
            $error = "Błąd podczas rejestracji";
        }
    }
}
?>
<?php if (isset($_SESSION['message'])): ?>
    <div class="message <?php echo $_SESSION['message_type']; ?>">
        <?php 
        echo $_SESSION['message'];
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
        ?>
    </div>
<?php endif; ?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja - Alekino</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="images/png" sizes="64x64" href="zdjecia/logo/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="zdjecia/logo/logo.png" alt="Alekino Logo">
            <h1>Alekino!</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Strona główna</a></li>
                <li><a href="login.php">Logowanie</a></li>
            </ul>
        </nav>
    </header>

    <main class="register-container">
        <div class="register-header">
            <i class="fas fa-user-plus"></i>
            <h2>Rejestracja</h2>
        </div>

        <?php if (isset($error)): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form class="register-form" method="POST" action="">
            <div class="form-group">
                <label for="imie"><i class="fas fa-user"></i> Imię</label>
                <input type="text" id="imie" name="imie" required>
            </div>

            <div class="form-group">
                <label for="nazwisko"><i class="fas fa-user"></i> Nazwisko</label>
                <input type="text" id="nazwisko" name="nazwisko" required>
            </div>

            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="telefon"><i class="fas fa-phone"></i> Telefon</label>
                <input type="tel" id="telefon" name="telefon" pattern="[0-9]{9}" required>
            </div>

            <button type="submit">
                <i class="fas fa-user-plus"></i> Zarejestruj się
            </button>

            <div class="login-link">
                Masz już konto? <a href="login.php">Zaloguj się</a>
            </div>
        </form>
    </main>
</body>
</html>
