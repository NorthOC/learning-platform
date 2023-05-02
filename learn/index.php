<?php 
session_start();

if (!isset($_SESSION['email']) || !isset($_SESSION['id'])) {
  header("Location: ../login/index.php");
  die();
}

$course_id = test_input($_GET['id']);

if (!is_numeric($course_id)) {
  header("location: ../courses");
  die();
} 

$user_id = $_SESSION['id'];
$user_type = $_SESSION['type'];

$config = include($_SERVER["DOCUMENT_ROOT"] . "/teensteaching/config.php");

//db connection
$mysqli = new mysqli($config['db_host'], $config['db_username'], $config['db_password'], $config['db_database']);
// check if course can and was purchased by user
$can_purchase = false;
$was_purchased = false;

if ($user_type == 'student'){
  $can_purchase = true;
}

if ($can_purchase){
  $qry = "SELECT id FROM Purchased_courses WHERE course_id = '$course_id' AND user_id = '$user_id' LIMIT 1";

  $result = $mysqli->query($qry);

  if (!$result) {
    die('Error: ' . $mysqli->connect_error);
  }

  if (mysqli_num_rows($result) > 0) {
    $was_purchased = true;
  }
}

if (!$was_purchased){
  header("location: ../courses");
  die();
}

$qry = "SELECT * FROM courses WHERE id='$course_id' LIMIT 1";

if ($mysqli->connect_error) {
  die("Connection error: " . $mysqli->connect_error);
}

$result = $mysqli->query($qry);

if (!$result) {
  die('Error: ' . $mysqli->connect_error);
} 
elseif (mysqli_num_rows($result) != 1) {
  die('Error: There seems to be a problem with this course.');
}

$course = mysqli_fetch_array($result);
$course_lessons = json_decode($course['json_blob'], true);

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
//this is where the user can look at specific course lessons and learn.
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../partials/stylesheets.php'; ?>
    <title><?php echo $course['course_name']." | Teensteaching"; ?></title>
</head>

<body>
    <?php include '../partials/nav.php'; ?>
    <h1><?php echo $course['course_name']; ?></h1>
    <?php
    echo "<p>No. of lessons: $lesson_count</p>";
    if (is_array($course_lessons) || is_object($course_lessons)){
      $count = 1;
      foreach($course_lessons as $item){
        echo "<button type='button' class='collapsible'>".$count.". ".$item['title']."</button>";
        echo "<div class='collaps-content'>";
        echo "<p>";
        echo $item['desc'];
        echo "</p>";
        echo "<p>";
        echo "Resource: ";
        echo $item['link'];
        echo "</p>";
        echo "</div>"; 
        $count += 1;
      }
    }
    ?>
    <?php include '../partials/footer.php'; ?>
    <script>
    var coll = document.getElementsByClassName("collapsible");

    for (var i = 0; i < coll.length; i++) {
      coll[i].addEventListener("click", function() {
        this.classList.toggle("collaps-active");
        var content = this.nextElementSibling;
        if (content.style.maxHeight){
          content.style.maxHeight = null;
        } else {
          content.style.maxHeight = content.scrollHeight + "px";
        }
      });
    }
    </script>
</body>
</html>