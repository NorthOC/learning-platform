<?php
//galima apžiūrėti visus galimus kursus, nueiti iki mokytojo profilio, tenais jį įvertinti
session_start();
if(!isset($_SESSION['email'])){
    header('Location: ../login/login-student.php');
};

$config = include($_SERVER["DOCUMENT_ROOT"]."/teensteaching/config.php");
$info_err = "";

$db = new mysqli ($config['db_host'], $config['db_username'], $config['db_password'], $config['db_database']);

if($db->connect_error){
    die();
}
else{
   $qry = "SELECT * FROM Courses";
    $result = $db->query($qry);
    if($result){
        if(!(mysqli_num_rows($result) > 0)){
            //$info_err = "There is no information";
        }
        else{
            $row = mysqli_fetch_row($result);
}

    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of all courses</title>
<style>
    table, th, td {
    border:1px solid black;
}
td{
    text-align: center;
}
</style>
</head>
<body>
    <h1>List of all courses availiable</h1>
    <table>
    <tr>
        <th>Teacher's first name</th>
        <th>Teacher's last name</th>
        <th>Course subject</th>
        <th>Course type</th>
        <th>Course difficulty</th>
        <th>Course name</th>
        <th>Price</th>
    </tr>
    <tbody>
    <?php
    foreach($result as $item){
        $t_id = $item['teacher_id'];
        $qry = "SELECT first_name, last_name FROM Teacher_profiles WHERE teacher_id = '$t_id' LIMIT 1";
        $r = $db->query($qry);
    if($r){
        if(!(mysqli_num_rows($r) > 0)){
            //$info_err = "There is no information";
        }
        else{
            $row = mysqli_fetch_row($r);
        }
    }
?>
<tr>
<td><?php echo $row[0].''; ?></td>
<!--<td><?php //echo "<a href='link'>Name</a>";?></td>-->
<td><?php echo $row[1].''; ?></td>
<td><?php echo $item['course_subject'].''; ?></td>
<td><?php echo $item['course_type'].''; ?></td>
<td><?php echo $item['course_difficulty'].''; ?></td>
<td><?php echo $item['course_name'].''; ?></td>
<td><?php echo $item['course_price'].''; ?></td>
</tr>
<?php } 
?>
</tbody>
</table>

<a href="../dashboard.php">Return</a>
</body>
</html>