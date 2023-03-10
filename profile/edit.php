<?php
session_start();

//Pridėt kad galėtų keist vardą pavardę, bio, ir nuotrauką

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

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_row($result);
                $profile_id = $row[0];
                $fname = $row[2];
                $lname = $row[3];
                $avatar = $row[4];
                $bio = $row[5];
                if (empty($avatar)) {
                    $avatar = '../static/images/default-avatar.png';
                } else {
                    $avatar = "../static/users/$profile_id/avatar.png";
                }
            }
        } else {
            die('Error: ' . $mysqli->connect_error);
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
</head>
<body>
    <h1>Edit your profile</h1>
<form action="insert.php" method="post">
<p>
<label for="firstName">First name</label>
<input type="text" name="first_name" id="firstName" required>
</p>
<p>
<label for="lastName">Last name</label>
<input type="text" name="last_name" id="lastName" required>
</p>
<p>
<label for="biography">About you</label>
<input type="text" name="biography" id="biography" size="30">
</p>
<input type="submit" value="Submit">
</form>
<br>

<p>Your photo: </p>
<br>
<img src="<?php echo htmlspecialchars($avatar); ?>" alt="test" />
<br>
<!--form action="fileUploadScript.php" method="post" enctype="multipart/form-data">
        Change your profile picture:
        <input type="file" name="the_file" id="fileToUpload">
        <input type="submit" name="submit" value="Start Upload">
    </form-->



</body>
</html>

<?php
//bandau išsiųsti duomenis iš form elemento (vardas, pavarde, biografija), paspaudus submit, pradeda veikti insert.php failas, kuris turėtų pasiimti iš formos duomenis ir išsiųst į duombazę.


?>