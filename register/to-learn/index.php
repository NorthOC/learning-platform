<?php

$emailErr = $passErr = $fnameErr = $lnameErr = '';

if (isset($_POST['form_submit'])){


    $configs = require($_SERVER['DOCUMENT_ROOT'].'/teensteaching/config.php');

    //form handling
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
    $fname = test_input($_POST['fname']);
    $lname = test_input($_POST['lname']);
    //tables
    $users_table = $configs['dbt_users'];
    $user_profiles_table = $configs['dbt_user_profiles'];

    //ERROR CHECKING
    $continue = true;
    //email errors
    if (empty($email)){
        $continue = false;
        $emailErr = 'Email field is empty.';
        
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $continue = false;
            $emailErr = "Invalid email format. Email format: example@example.xyz";
            }
        
    };

    //pass errors
    if (empty($password)){
        $continue = false;
        $passErr = 'Password field is empty.';
    } else {
        if (strlen($password) < 6){
            $continue = false;
            $passErr = 'Password must be at least 6 characters';
        }
    };

    //first_name errors
    if (empty($fname)){
        $continue = false;
        $fnameErr = 'First name field is empty.';
        
    }
    //last_name errors
    if (empty($lname)){
        $continue = false;
        $lnameErr = 'Last name field is empty.';
        
    }

    // if all good
    if($continue === true) {
    
        //db connection
        $mysqli = new mysqli ($configs['db_host'], $configs['db_username'], $configs['db_password'], $configs['db_database']);


        if (!$mysqli->connect_error) {

            //check if email exists
            $qry="SELECT * FROM $users_table WHERE email='$email' LIMIT 1";
            $result = $mysqli->query($qry);

            if ($result){
                if (mysqli_num_rows($result) > 0) {
                    $emailErr = 'This email is already taken';
                    $continue = false;
                }
            } else {
                //echo 'Error: ' . $mysqli->connect_error;
                $continue = false;
            }

            if ($continue){
                // CREATING RECORDS

                // hashing password
                $password_hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);

                // create user
                $record = "INSERT INTO $users_table (email, password) VALUES ('$email', '$password_hash')";
                if ($mysqli->query($record) === TRUE) {
                    //echo "Sukurtas vartotojas <br>";

                    // create user profile
                    $record="SELECT id FROM $users_table WHERE email='$email' LIMIT 1";
                    $result = $mysqli->query($record);

                    //$row[0] yra id
                    $row = mysqli_fetch_row($result);
                    $record = "INSERT INTO $user_profiles_table (user_id, first_name, last_name) VALUES ('$row[0]', '$fname', '$lname')";
                    if ($mysqli->query($record) === TRUE) {
                        header("Location: ../../login/index.php?status=1");
                    } else {
                        // IF FAILED TO CREATE USER_PROFILE REMOVE RECORD FROM USER TABLE
                        $record = "DELETE FROM $users_table WHERE email = '$email'";
                        $mysqli->query($record);
                        die("Could not create user profile");
                    }
                    


                } else {
                    die("Įrašyti nepavyko");
                }
            }
        } else {
            die("Prisijungti nepavyko: " . $mysqli->connect_error);
        }
        $mysqli->close();
    }

}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../../partials/stylesheets.php'; ?>
    <title>Document</title>
</head>
<body>
    <?php include '../../partials/nav.php';?>
    <h1>Register as a learner</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <div class="form-group">
            <label for="fname">First Name</label>
            <input type="text" class='form-control'name="fname" id="fname" value="<?php if (isset($fname)) {
                echo $fname;}; ?>">
            <span class="error"><?php echo $fnameErr;?></span>
        </div>
        <div class="form-group">
            <label for="lname">Last Name</label>
            <input type="text" class='form-control'name="lname" id="lname" value="<?php if (isset($lname)) {
                echo $lname;}; ?>">
            <span class="error"><?php echo $lnameErr;?></span>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class='form-control'name="email" id="email" value="<?php if (isset($email)) {
                echo $email;}; ?>">
            <span class="error"><?php echo $emailErr;?></span>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class='form-control'name="password" id="password">
            <span class="error"><?php echo $passErr;?></span>
        </div>
        <button type="submit" class='btn btn-primary'name="form_submit">Register</button>
    </form>
</body>
</html>