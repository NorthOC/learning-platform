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
        $edit_course = false;
    } else {
        $table = $config['dbt_teacher_profiles'];
        $fkey = 'teacher_id';
        $edit_course = true;
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.css">
    <title>Document</title>
</head>
<body>
    <p>Name: <?php echo $fname." ".$lname; ?></p>
    <p>Type: <?php echo $type; ?></p>
    <p>Avatar: <img src="<?php echo $avatar; ?>" alt=""></p>
    <p>Bio: <?php echo $bio; ?></p>
    <?php if($edit_course === true){echo '<a href="./course/new.php">Add new course</a>';}?>
    <!--<a href="./course/view.php">View courses</a> -->
 
<?php //Mokytojui bus matomas jo turiamų sukurtų kursų sąrašas
if($_SESSION['type']=='teacher'){
    $qqry = "SELECT course_difficulty, course_name,course_description FROM Courses WHERE teacher_id='$id'";
    $r = $mysqli->query($qqry);
if($r){
    if(!(mysqli_num_rows($r)>0)){
        echo "There's nothing here";
        //$info_err = "There is no information";
    }
}
while($row = mysqli_fetch_array($r)){
    $course_name = $row['course_name'];
    $course_desc = $row['course_description'];
    $course_diff = $row['course_difficulty'];
   // echo $course_name." ".$course_desc." ".$course_diff."<br>";


   //Pridėti kursų korteles, bei padaryt, kad jeigu jokių kortelių nėra, būtų rodomas tekstas "There's nothing here, start by adding new courses"
   
}

}
$mysqli->close();
?>
    
</body>
</html>