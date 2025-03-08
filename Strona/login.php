<?php
require_once 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $haslo = trim($_POST['haslo']);

    $stmt = $db->prepare("SELECT klient_id, imie, nazwisko, haslo FROM klienci WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($haslo, $user['haslo'])) {
        $_SESSION['user_id'] = $user['klient_id'];
        $_SESSION['user_name'] = $user['imie'] . ' ' . $user['nazwisko'];
        $_SESSION['message'] = "Zalogowano pomyślnie!";
        $_SESSION['message_type'] = "success";
        header('Location: konto.php');
        exit();
    } else {
        $_SESSION['message'] = "Nieprawidłowy email lub hasło";
        $_SESSION['message_type'] = "error";
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
                <li><a href="rejestracja.php">Rejestracja</a></li>
            </ul>
        </nav>
    </header>

    <main class="login-container">
        <div class="login-header">
            <i class="fas fa-user-circle"></i>
            <h2>Logowanie</h2>
        </div>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="message <?php echo $_SESSION['message_type']; ?>">
                <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
                ?>
            </div>
        <?php endif; ?>

        <form class="login-form" method="POST" action="">
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="haslo"><i class="fas fa-lock"></i> Hasło</label>
                <div class="password-container">
                    <input type="password" id="haslo" name="haslo" required>
                    <i class="fas fa-eye password-toggle" onclick="togglePassword('haslo')"></i>
                </div>
            </div>

            <div class="form-group">
                <label for="telefon"><i class="fas fa-phone"></i> Telefon</label>
                <input type="tel" id="telefon" name="telefon" pattern="[0-9]{9}" required>
            </div>

            <button type="submit">
                <i class="fas fa-sign-in-alt"></i> Zaloguj się
            </button>

            <div class="register-link">
                Nie masz konta? <a href="rejestracja.php">Zarejestruj się</a>
            </div>
        </form>
    </main>
    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling;

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>