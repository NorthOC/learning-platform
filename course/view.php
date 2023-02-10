<?php
if (isset($_GET['id'])){
  $course_id = test_input($_GET['id']);
  echo "reached with course_id: ".$course_id;
} else{
  header("location: ../courses");
  die();
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>