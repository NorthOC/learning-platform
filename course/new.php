<?php
session_start();
 if (!isset($_SESSION['email'])) {
     header("Location: ../login/login-student.php");
     die();
 }
 if ($_SESSION["type"] == "student") {
     header("Location: ../dashboard.php");
     die();
 }

$titleErr = $subjectErr = $typeErr = $priceErr = '';

//POST 
if (isset($_POST['submit-form'])){

    $config = include($_SERVER["DOCUMENT_ROOT"]."/teensteaching/config.php");
    $type = $_SESSION['type'];
    $id = $_SESSION['id'];

    $course_title = test_input($_POST['title']);
    $course_subject = test_input($_POST['course_subject']);
    $course_type = test_input($_POST['course_type']);
    $course_difficulty = test_input($_POST['course_difficulty']);
    $course_price = test_input($_POST['price']);

    //errs
    $continue = true;

    if (empty($course_title)){
        $titleErr = "The title of the course should be set";
        $continue = false;
    }
    if (empty($course_subject)){
        $subjectErr = "Please choose a subject";
        $continue = false;
    }
    if (empty($course_type)){
        $typeErr = "Please choose a proper lesson type";
        $continue = false;
    }
    if (empty($course_difficulty)){
        $diffErr = "Please select a proper difficulty";
        $continue = false;
    }
    if(empty($course_price)){
        $priceErr = "Please select a proper difficulty";
        $continue = false;
    }


    if ($continue){
        //db connection
        $table = $config['dbt_courses'];

        $mysqli = new mysqli ($config['db_host'], $config['db_username'], $config['db_password'], $config['db_database']);


        if (!$mysqli->connect_error) {

            //grab user profile
            $record = "INSERT INTO $table (teacher_id, course_subject, course_type, course_difficulty, course_name, course_price) VALUES ('$id', '$course_subject', '$course_type', '$course_difficulty', '$course_title', '$course_price')";
            $result = $mysqli->query($record);
            //echo "Selecting";
            if ($result){
                //echo "Result";
                $last_id = $mysqli->insert_id;
                header("Location: ../lesson/lesson.php?course_id=".$last_id);
                exit();

            } else {
                die('Error: ' . $mysqli->connect_error);
                }
        } else {
            die("Connect error: " . $mysqli->connect_error);
        }
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
    <title>Document</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
        <label for="title">Course title:</label>
        <input type="text" name="title" required>

        <label for="subject" name="subject">Subject:</label>
        <select name="course_subject" id="subject_select">
            <option value="" disabled>Art</option>
            <option value="photography">Photography</option>
            <option value="videography">Videography</option>
            <option value="music">Music</option>
            <option value="digital-art">Digital art</option>
            <option value="drawing">Drawing</option>
            <option value="painting">Painting</option>
            <option value="writing">Writing</option>
            <option value="" disabled>Science</option>
            <option value="physics">Physics</option>
            <option value="math">Math</option>
            <option value="biology">Biology</option>
            <option value="programming">Programming</option>
            <option value="chemistry">Chemistry</option>
            <option value="engineering">Engineering</option>
            <option value="electronics">Electronics</option>
            <option value="medicine">Medicine</option>
            <option value="" disabled>Humanities</option>
            <option value="history">History</option>
            <option value="psychology">Psychology</option>
            <option value="philosoplhy">Philosophy</option>
            <option value="" disabled>Business</option>
            <option value="economics">Economics</option>
            <option value="entrepreneurship">Entrepreneurship</option>
            <option value="marketing">Marketing</option>
            <option value="" disabled>Fitness</option>
            <option value="sports">Sports</option>
            <option value="nutrition">Nutrition</option>
            <option value="" disabled>Other</option>
            <option value="language">Language learning</option>
            <option value="social-skills">Social skills</option>
            <option value="other">Other</option>
        </select>

        <label for="course_type">Form of studies: </label>
        <select name="course_type" id="course_type">
            <option value="live">Individual</option>
            <option value="classroom">Classroom</option>
            <option value="video">Video</option>
            <option value="theory">Theory</option>
        </select>

        <label for="course_difficulty">Course difficulty: </label>
        <select name="course_difficulty" id="">
            <option value="beginner">Beginner</option>
            <option value="intermediate">Intermediate</option>
            <option value="advanced">Advanced</option>
            <option value="masterclass">Masterclass</option>
        </select>

        <label for="price">Course price (€): </label>
        <input type="number" name="price" placeholder="5.5" min="1" step="any"/>
        <button type="submit" name="submit-form">Create course</button>
    </form>
</body>
</html>