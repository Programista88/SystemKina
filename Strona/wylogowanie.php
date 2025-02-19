<?php
session_start();
session_destroy();
session_start();
$_SESSION['message'] = "Wylogowano pomyślnie!";
$_SESSION['message_type'] = "success";
header(header: 'Location: index.php');
exit();
?>
