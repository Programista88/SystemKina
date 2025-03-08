<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['rezerwacja_id'])) {
    header('Location: login.php');
    exit();
}

$rezerwacja_id = $_GET['rezerwacja_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $metoda_platnosci = $_POST['metoda_platnosci'];

    if ($metoda_platnosci === 'karta') {
        $numer_karty = $_POST['numer_karty'];
        $data_waznosci = $_POST['data_waznosci'];
        $cvv = $_POST['cvv'];

        $platnosc_udana = true;
    } elseif ($metoda_platnosci === 'blik') {
        $kod_blik = $_POST['kod_blik'];


        if (strlen($kod_blik) === 6) {
            $platnosc_udana = true;
        }
    }

    if ($platnosc_udana) {
        try {

            $stmt = $db->prepare("
                SELECT s.cena 
                FROM rezerwacje r
                JOIN seanse s ON r.seans_id = s.seans_id
                WHERE r.rezerwacja_id = ?
            ");
            $stmt->execute([$rezerwacja_id]);
            $kwota = $stmt->fetchColumn();


            $db->beginTransaction();


            $stmt = $db->prepare("
                INSERT INTO platnosci (rezerwacja_id, kwota, metoda_platnosci) 
                VALUES (?, ?, ?)
            ");
            $stmt->execute([$rezerwacja_id, $kwota, $metoda_platnosci]);


            $stmt = $db->prepare("
                UPDATE rezerwacje 
                SET status = 'aktywna', data_platnosci = NOW() 
                WHERE rezerwacja_id = ?
            ");
            $stmt->execute([$rezerwacja_id]);

            $db->commit();

            $_SESSION['message'] = "Płatność została zrealizowana pomyślnie!";
            $_SESSION['message_type'] = "success";
            header('Location: rezerwacje.php');
            exit();
        } catch (PDOException $e) {
            $db->rollBack();
            $_SESSION['message'] = "Wystąpił błąd podczas realizacji płatności";
            $_SESSION['message_type'] = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Płatność - Alekino</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="images/png" sizes="64x64" href="zdjecia/logo/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <main class="payment-container">
        <h2>Wybierz metodę płatności</h2>

        <div class="payment-methods">
            <div class="payment-method" onclick="showPaymentForm('karta')">
                <i class="fas fa-credit-card"></i>
                <span>Karta płatnicza</span>
            </div>

            <div class="payment-method" onclick="showPaymentForm('blik')">
                <i class="fas fa-mobile-alt"></i>
                <span>BLIK</span>
            </div>
        </div>

        <form id="karta-form" class="payment-form" style="display: none;" method="POST">
            <input type="hidden" name="metoda_platnosci" value="karta">
            <div class="form-group">
                <label>Numer karty</label>
                <input type="text" name="numer_karty" pattern="[0-9 ]{19}" maxlength="19" required>
            </div>
            <div class="form-group">
                <label>Data ważności</label>
                <input type="text" name="data_waznosci" placeholder="MM/RR" pattern="[0-9]{2}/[0-9]{2}" required>
            </div>
            <div class="form-group">
                <label>CVV</label>
                <input type="text" name="cvv" pattern="[0-9]{3}" maxlength="3" required>
            </div>
            <button type="submit">Zapłać</button>
        </form>

        <form id="blik-form" class="payment-form" style="display: none;" method="POST">
            <input type="hidden" name="metoda_platnosci" value="blik">
            <div class="form-group">
                <label>Kod BLIK</label>
                <input type="text" name="kod_blik" pattern="[0-9]{6}" maxlength="6" required>
            </div>
            <button type="submit">Zapłać</button>
        </form>
    </main>

    <script>
        function showPaymentForm(method) {
            document.getElementById('karta-form').style.display = 'none';
            document.getElementById('blik-form').style.display = 'none';
            document.getElementById(method + '-form').style.display = 'block';
        }
    </script>
    <script>
        document.querySelector('input[name="numer_karty"]').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\s/g, '');
            let formattedValue = value.replace(/(\d{4})/g, '$1 ').trim();
            e.target.value = formattedValue;
        });
    </script>
    <script>
        document.querySelector('input[name="data_waznosci"]').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                let month = parseInt(value.slice(0, 2));
                if (month > 12) {
                    month = 12;
                    value = '12' + value.slice(2);
                } else if (month < 1) {
                    month = '01';
                    value = '01' + value.slice(2);
                }
                value = value.slice(0, 2) + '/' + value.slice(2, 4);
            }
            e.target.value = value;
        });

        document.getElementById('karta-form').addEventListener('submit', function (e) {
            const expiryInput = document.querySelector('input[name="data_waznosci"]').value;
            const [month, year] = expiryInput.split('/');

            const currentDate = new Date();
            const currentYear = currentDate.getFullYear() % 100;
            const currentMonth = currentDate.getMonth() + 1;

            const expYear = parseInt(year);
            const expMonth = parseInt(month);

            if (expYear < currentYear || (expYear === currentYear && expMonth < currentMonth)) {
                e.preventDefault();
                alert('Karta jest nieważna - sprawdź datę ważności');
            }
        });
    </script>

</body>

</html>