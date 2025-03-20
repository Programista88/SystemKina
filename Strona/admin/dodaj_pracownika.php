<?php
session_start();
require_once '../konfiguracja/config.php';

if (!isset($_SESSION['pracownik_id']) || $_SESSION['pracownik_stanowisko'] !== 'admin') {
    header('Location: panel_pracownika.php');
    exit();
}

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';
$messageType = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imie = trim($_POST['imie']);
    $nazwisko = trim($_POST['nazwisko']);
    $email = trim($_POST['email']);
    $haslo = trim($_POST['haslo']);
    $stanowisko = $_POST['stanowisko'];


    if (empty($imie) || empty($nazwisko) || empty($email) || empty($haslo) || empty($stanowisko)) {
        $message = 'Wszystkie pola są wymagane!';
        $messageType = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Podaj poprawny adres email!';
        $messageType = 'error';
    } else {

        $stmt = $conn->prepare("SELECT email FROM pracownicy WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = 'Pracownik z tym adresem email już istnieje!';
            $messageType = 'error';
        } else {

            $hashedPassword = password_hash($haslo, PASSWORD_DEFAULT);


            $stmt = $db->prepare("INSERT INTO pracownicy (imie, nazwisko, email, telefon, haslo, stanowisko) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$imie, $nazwisko, $email, $telefon, $haslo_hash, $stanowisko]);

            if ($stmt->execute()) {
                $message = 'Pracownik został pomyślnie dodany!';
                $messageType = 'success';

                $imie = $nazwisko = $email = $haslo = '';
                $stanowisko = 'pracownik';
            } else {
                $message = 'Wystąpił błąd podczas dodawania pracownika: ' . $conn->error;
                $messageType = 'error';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Dodaj Pracownika - Alekino</title>
    <link rel="stylesheet" href="../zasoby/css/style.css">
    <link rel="icon" type="images/png" sizes="64x64" href="../zdjecia/logo/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <header>
        <div class="logo-container">
            <img src="../zdjecia/logo/logo.png" alt="Alekino Logo">
            <h1>Alekino!</h1>
        </div>
        <nav>
            <ul>
                <li><a href="../index.php">Strona główna</a></li>
                <li><a href="panel_pracownika.php">Panel Pracownika</a></li>
                <?php if (isset($_SESSION['pracownik_id'])): ?>
                    <li><a href="konto_pracownika.php">Konto (Pracownik)</a></li>
                    <li><a href="../autoryzacja/logout.php" class="logout-btn">Wyloguj</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <div class="admin-form">
            <h2><i class="fas fa-user-plus"></i> Dodaj Nowego Pracownika</h2>

            <?php if (!empty($message)): ?>
                <div class="message <?php echo $messageType; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="imie"><i class="fas fa-user"></i> Imię</label>
                    <input type="text" id="imie" name="imie"
                        value="<?php echo isset($imie) ? htmlspecialchars($imie) : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="nazwisko"><i class="fas fa-user"></i> Nazwisko</label>
                    <input type="text" id="nazwisko" name="nazwisko"
                        value="<?php echo isset($nazwisko) ? htmlspecialchars($nazwisko) : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" id="email" name="email"
                        value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="telefon"><i class="fas fa-phone"></i> Telefon</label>
                    <input type="tel" id="telefon" name="telefon" pattern="[0-9]{9}" required>
                </div>

                <div class="form-group">
                    <label for="haslo"><i class="fas fa-lock"></i> Hasło</label>
                    <div class="password-container">
                        <input type="password" id="haslo" name="haslo" required>
                        <i class="fas fa-eye password-toggle" onclick="togglePassword()"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="stanowisko"><i class="fas fa-id-badge"></i> Stanowisko</label>
                    <select id="stanowisko" name="stanowisko" required>
                        <option value="pracownik" <?php echo (isset($stanowisko) && $stanowisko === 'pracownik') ? 'selected' : ''; ?>>Pracownik</option>
                        <option value="kierownik" <?php echo (isset($stanowisko) && $stanowisko === 'kierownik') ? 'selected' : ''; ?>>Kierownik</option>
                        <option value="admin" <?php echo (isset($stanowisko) && $stanowisko === 'admin') ? 'selected' : ''; ?>>Administrator</option>
                    </select>
                </div>

                <button type="submit"><i class="fas fa-plus-circle"></i> Dodaj Pracownika</button>
            </form>

            <div style="margin-top: 20px; text-align: center;">
                <a href="zarzadzaj_pracownikami.php" class="return-btn">
                    <i class="fas fa-arrow-left"></i> Powrót do zarządzania pracownikami
                </a>
            </div>
        </div>
    </main>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('haslo');
            const toggleIcon = document.querySelector('.password-toggle');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>