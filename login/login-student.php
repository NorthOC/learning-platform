<?php
// Initialize the session
//session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: ../dashboard.php");
    echo "Welcome!";
    exit;
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
};
$email = $password = "";
$email_err = $password_err = $login_err = "";
$emailErr = $passErr = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){
   
// Define variables and initialize with empty values

    // Include config file
    $config = include($_SERVER["DOCUMENT_ROOT"]."/teensteaching/config.php");
    
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);

    if ($_POST["type"] == 'student'){
        $table = $config['dbt_users'];
        $session_type = 'student';
    } else {
        $table = $config['dbt_teachers'];
        $session_type = 'teacher';
    }

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

    if($continue === true) {
        $db = new mysqli ($config['db_host'], $config['db_username'], $config['db_password'], $config['db_database']);

        if (!$db->connect_error) {

            //check if email exists
            $qry="SELECT id, email, password FROM $table WHERE email='$email' LIMIT 1";
            $result = $db->query($qry);
            if($result){
                if(!(mysqli_num_rows($result) > 0)){
                    $emailErr = "Tokio pašto mūsų sistemoje nėra";
                }
                else{
                    $row = mysqli_fetch_row($result);
                $isPassword = password_verify($password,$row[2]);
                if($isPassword==true){
                    session_start();
                    $_SESSION["id"] = "$row[0]";
                    $_SESSION["email"] = "$row[1]";
                    $_SESSION["type"] = $session_type;
                    header("Location: ../dashboard.php");
                    die();
                    //echo "Esate prisijungęs";
                }
                else{
                    $passErr = "slaptažodis yra neteisingas";
                }
                }
                
            }

    }
}

}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="error"><?php echo $emailErr;?></span>
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
                <span class="error"><?php echo $passErr;?></span>
            </div>
            <div class="form-group">
                <label>Login as: </label>
                <select name="type" id="">
                    <option value="student" selected>Student</option>
                    <option value="teacher">Teacher</option>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>