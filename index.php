<?php
$configs = include('config.php');

$db = new mysqli ($configs['db_host'], $configs['db_username'], $configs['db_password'], $configs['db_database']);

if (!$db->connect_error) {
    echo "Prisijungti pavyko <br>";
} 
else {
    die("Prisijungti nepavyko: " . $db->connect_error);
}

?>