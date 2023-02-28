<?php
if (isset($_SESSION['email'])) {
    $config = include($_SERVER["DOCUMENT_ROOT"] . "/teensteaching/config.php");
    $id = $_SESSION['id'];
    $type = $_SESSION['type'];
    $user_profiles_table = $configs['dbt_user_profiles'];

    if ($_SESSION["type"] == "student") {
        $table = $config['dbt_user_profiles'];
        $fkey = 'user_id';
    } else {
        $table = $config['dbt_teacher_profiles'];
        $fkey = 'teacher_id';
    }

    $mysqli = new mysqli($config['db_host'], $config['db_username'], $config['db_password'], $config['db_database']);
    

    $first_name = $_REQUEST['first_name'];
    $last_name = $_REQUEST['last_name'];
    $abtme = $_REQUEST['biography'];

    //problema edit.php faile (galimai), nes nieko neišveda
    echo $first_name." ".$last_name." ".$abtme;

    $sql = "INSERT INTO $user_profiles_table (first_name, last_name,bio) VALUES ('$first_name','$last_name','$abtme') WHERE $fkey = '$id'";

    if(mysqli_query($mysqli,$sql)){
        echo "duomenys issiusti";
    }
    else {
        die('Error: ' . $mysqli->connect_error);
    }
    $mysqli->close();
}
?>