<?php
session_start();

if (!isset($_POST)){
  header("location: ../courses");
  die();
}

$course_id = test_input($_POST['course_to_purchase']);

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
$qry = "SELECT * FROM Courses WHERE id='$course_id' LIMIT 1";

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
$course_price = $course['course_price'];
$teacher_id = $course['teacher_id'];
// check if course can and was purchased by user
$can_purchase = false;
$was_purchased = false;

if ($user_type == 'student'){
  $can_purchase = true;
}

if (!$can_purchase){
  die('Error: Only student accounts are allowed to purchase courses.');
}

$qry = "SELECT id FROM Purchased_courses WHERE course_id='$course_id' AND user_id='$user_id' LIMIT 1";

$result = $mysqli->query($qry);

if (!$result) {
  die('Error: ' . $mysqli->connect_error);
}

if (mysqli_num_rows($result) > 0) {
  $was_purchased = true;
}

if ($was_purchased){
  header("Location: ../learn?id=$course_id");
  die();
}

$qry = "SELECT credit FROM Users WHERE id='$user_id' LIMIT 1";
$result = $mysqli->query($qry);

if (!$result) {
  die('Error: ' . $mysqli->connect_error);
}

if (!mysqli_num_rows($result) > 0) {
  die('Error: UserError');
}

$credit = mysqli_fetch_array($result);
$credit = $credit['credit'];

$has_enough_money = false;
$purchase_successful = false;
$credit_after_purchase = $credit - $course_price;

if ($credit_after_purchase >= 0){
  $has_enough_money = true;
}

if ($has_enough_money){
  $qry = "INSERT INTO Purchased_courses (course_id, user_id) VALUES ('$course_id', '$user_id')";
  $result = $mysqli->query($qry);

  if (!$result) {
    die('Error: ' . $mysqli->connect_error);
  }

  $qry = "UPDATE Users SET credit='$credit_after_purchase' WHERE id='$user_id'";
  $result = $mysqli->query($qry);

  if (!$result) {
    die('Error: ' . $mysqli->connect_error);
  }
  $purchase_successful = true;

  //comission to teachers
  $comission = round($course_price*0.8, 2);

  $qry = "UPDATE Teachers SET credit=credit+'$comission' WHERE id='$teacher_id'";
  $result = $mysqli->query($qry);

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
    <title>Enrollment status</title>
</head>

<body>
    <?php include '../partials/nav.php'; ?>

<?php if ($has_enough_money & $purchase_successful) { ?>
  <p>Course purchase was successful!</p>
  <p><a href="<?php echo "../learn?id=$course_id"; ?>">Click here</a> to view your course!</p>

<?php } else { ?>
  <p>Insuficient funds. Please top up your balance.</p>

  <?php }; ?>

<?php include '../partials/footer.php'; ?>
</body>
</html>