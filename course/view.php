<?php
session_start();

if (!isset($_GET['id'])){
  header("location: ../courses");
  die();
}

$course_id = test_input($_GET['id']);

if (!is_numeric($course_id)) {
  header("location: ../courses");
  die();
} 
elseif (!isset($_SESSION['email']) || !isset($_SESSION['id'])) {
  header("Location: ../login/index.php");
  die();
}

$user_id = $_SESSION['id'];
$user_type = $_SESSION['type'];

$config = include($_SERVER["DOCUMENT_ROOT"] . "/teensteaching/config.php");

//db connection
$mysqli = new mysqli($config['db_host'], $config['db_username'], $config['db_password'], $config['db_database']);
$qry = "SELECT * FROM Courses WHERE id = '$course_id' LIMIT 1";

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
    <title><?php echo $course['course_name']." | Teensteaching"; ?></title>
</head>

<body>
    <?php include '../partials/nav.php'; ?>
    <h1><?php echo $course['course_name']; ?></h1>
    <?php
    // todo normal course card
      if ($can_purchase && $was_purchased){
        echo '<a href="../learn">Learn now!</a>';
      }
      elseif ($can_purchase && !$was_purchased){
        $price = $course['course_price'];
        echo "<a href='../buy'>Enroll for €$price</a>";
      }
    ?>
    <?php include '../partials/footer.php'; ?>
</body>
</html>