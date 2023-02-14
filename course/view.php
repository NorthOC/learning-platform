<?php
session_start();
$config = include($_SERVER["DOCUMENT_ROOT"]."/teensteaching/config.php");
if (!isset($_GET['id'])){
  header("location: ../courses");
  die();
}
$course_id = test_input($_GET['id']);
if (empty($course_id) || !is_numeric($course_id)) {
  header("location: ../courses");
}

//db connection
$mysqli = new mysqli($config['db_host'], $config['db_username'], $config['db_password'], $config['db_database']);
if ($mysqli->connect_error) {
  die('Unable to connect to database');
}
$qry = "SELECT * FROM Courses WHERE id='$course_id' LIMIT 1";
$result = $mysqli->query($qry);

if (!$result) {
  die('Course not found');
}
//echo "Result";
if (!mysqli_num_rows($result) > 0) {
  die('Course not found');
}
$course_info = mysqli_fetch_array($result);
$author_id = $course_info['teacher_id'];
$qry = "SELECT first_name, last_name FROM Teacher_profiles WHERE teacher_id = '$author_id' LIMIT 1";
$result = $mysqli->query($qry);

if (!mysqli_num_rows($result) > 0){
  die('Course not found');
}
$author_info = mysqli_fetch_array($result);
$json_blob = json_decode($course_info['json_blob'], true);
if (!empty($json_blob)){
  $lesson_count = count($json_blob);
} else {
  $lesson_count = 0;
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
  <?php include '../partials/stylesheets.php'; ?>
  <title>Document</title>
</head>
<body>
  <?php include '../partials/nav.php'; ?>
  <div class="profile">
    <h1><?php echo $course_info['course_name']; ?></h1>
    <h2>Description</h2>
    <p>Course created at: <?php echo $course_info['creation_date']; ?></p>
    <p>Course difficulty: <?php echo $course_info['course_difficulty'];?></p>
    <p>Lesson type: <?php echo $course_info['course_type'];?></p>
    <p>Number of Lessons: <?php echo $lesson_count;?></p>
    <hr>
    <p>
    <?php
    if (isset($course_info['course_description'])) {
      echo $course_info['course_description'];
    } else {
      echo "No description.";
    }
    ?>
    </p>
    <?php 
    if (!isset($_SESSION['type'])) {
      echo "<a>Enroll for $".$course_info['course_price']." now!</a>";
    } elseif ($_SESSION['type'] != 'student') {
        echo "<a>Enroll for $".$course_info['course_price']." now!</a>";
    }
    ?>
  </div>

  <?php include '../partials/footer.php'; ?>
</body>
</html>