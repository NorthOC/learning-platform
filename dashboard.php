<?php
session_start();

if (isset($_SESSION['email'])){

    $config = include($_SERVER["DOCUMENT_ROOT"]."/teensteaching/config.php");
    $type = $_SESSION['type'];
    $id = $_SESSION['id'];

    //table
    if($_SESSION["type"] == "student"){
        $table = $config['dbt_user_profiles'];
        $fkey = 'user_id';
    } else {
        $table = $config['dbt_teacher_profiles'];
        $fkey = 'teacher_id';
    }
    //db connection
    $mysqli = new mysqli ($config['db_host'], $config['db_username'], $config['db_password'], $config['db_database']);


    if (!$mysqli->connect_error) {

        //grab user profile
        $qry="SELECT * FROM $table WHERE $fkey='$id' LIMIT 1";
        $result = $mysqli->query($qry);
        //echo "Selecting";

        if ($result){
            //echo "Result";
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_row($result);
                $profile_id = $row[0];
                $fname = $row[2];
                $lname = $row[3];
                $avatar = $row[4];
                $bio = $row[5];
                //echo "fetched";
                if (empty($avatar)){
                    $avatar = './static/images/default-avatar.png';
                } else {
                    $avatar = "./static/users/$profile_id/avatar.png";
                }
            }
        } else {
            die('Error: ' . $mysqli->connect_error);
        }
    } else {
        die("Prisijungti nepavyko: " . $mysqli->connect_error);
    }
    $mysqli->close();
}
else {
    header("Location: login/login-student.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Name: <?php echo $fname." ".$lname; ?></p>
    <p>Type: <?php echo $type; ?></p>
    <p>Avatar: <img src="<?php echo $avatar; ?>" alt=""></p>
    <p>Bio: <?php echo $bio; ?></p>
    <a href="./course/new"></a>
</body>
</html>