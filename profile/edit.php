<?php
session_start();

if (isset($_SESSION['email'])) {
    $config = include($_SERVER["DOCUMENT_ROOT"] . "/teensteaching/config.php");
    $id = $_SESSION['id'];
    $type = $_SESSION['type'];


    if ($_SESSION["type"] == "student") {
        $table = $config['dbt_user_profiles'];
        $fkey = 'user_id';
    } else {
        $table = $config['dbt_teacher_profiles'];
        $fkey = 'teacher_id';
    }

    $mysqli = new mysqli($config['db_host'], $config['db_username'], $config['db_password'], $config['db_database']);
    if (!$mysqli->connect_error) {
        $qry = "SELECT * FROM $table WHERE $fkey='$id' LIMIT 1";
        $result = $mysqli->query($qry);
        if($result){
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_row($result);
                $avatar = $row[4];
                if (empty($avatar)) {
                    $pfp = '../static/images/default-avatar.png';
                } else {
                    $pfp = "../profile_pictures/".$avatar;
                }
            }
        }






        if(isset($_POST['submit'])){
            $firstname = $_POST['first_name'];
            $lastname = $_POST['last_name'];
            $bio = $_POST['bio'];
            $sql = "UPDATE $table SET first_name='$firstname',last_name='$lastname',bio='$bio' WHERE $fkey='$id' LIMIT 1";
            mysqli_query($mysqli,$sql);
            } 

            if($_SESSION["type"] == "student"){
                $sql = "SELECT * FROM $table WHERE user_id =$fkey";
                $result = mysqli_query($mysqli,$sql);
                $row = mysqli_fetch_assoc($result);   
            }
            if($_SESSION["type"] == "teacher"){
                $sql = "SELECT * FROM $table WHERE teacher_id=$fkey";
                $result = mysqli_query($mysqli,$sql);
                $row = mysqli_fetch_assoc($result); 
            }

        }
    $mysqli->close();    
    }

    


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.css">
    <style>
        body{
            background-color: #FFCC00;
        }
    </style>
</head>
<body>
<h1>Edit your profile</h1>
 <div class='profile'>
<form method="post">
<p>
<label for="first_name">First name</label>
<input type="text" name="first_name" value="<?php echo $row['first_name'];?>" required>
</p>
<p>
<label for="last_name">Last name</label>
<input type="text" name="last_name" value="<?php echo $row['last_name'];?>" required>
</p>
<p>
<label for="bio">About you</label>
<input type="text" name="bio" value="<?php echo $row['bio'];?>" size="30">
</p>
<p>
<input type="submit" name="submit" value="Save information">
</form>
<form method="post" action= "upload.php" enctype="multipart/form-data">
<label for="avatar">Change profile picture:</label>
<input type="file" name="avatar" id="avatar">
<input type="submit" name="submit" value="Submit">
</form>
</div>
<br>

<h1>Your photo: </h1>
<img src="<?php echo htmlspecialchars($pfp); ?>" style="display: block; margin: 0 auto;" width='350' height='350'>
<form action="../dashboard.php" method="post">
<input type="submit" value="Grįžti atgal į meniu" style="display: block; margin: 0 auto;">
</form>


</body>
</html>
