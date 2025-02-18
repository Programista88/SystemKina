<?php
$host = 'localhost';
$dbname = 'system_kina';
$username = 'root';
$password = '';

try {
    $db = new PDO(dsn: "mysql:host=$host;dbname=$dbname;charset=utf8", username: $username, password: $password);
    $db->setAttribute(attribute: PDO::ATTR_ERRMODE, value: PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Błąd połączenia z bazą danych: " . $e->getMessage();
}
?>
