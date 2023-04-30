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
}


$target_dir = "../profile_pictures/";
$target_file = $target_dir . basename($_FILES["avatar"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["avatar"]["tmp_name"]);
  if($check !== false) {
    //echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    //echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["avatar"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
    $file_name = htmlspecialchars( basename( $_FILES["avatar"]["name"]));

    if ($_SESSION["type"] == "student") {
    $new_file_name = $fkey."_".$id.".jpg";
    }
    if ($_SESSION["type"] == "teacher") {
      $new_file_name = $fkey."_".$id.".jpg";
    }
    $rename = rename("../profile_pictures/$file_name","../profile_pictures/$new_file_name");
    $sql = "UPDATE $table SET avatar='$new_file_name' WHERE $fkey='$id'";
    mysqli_query($mysqli,$sql);
    //echo "The file ". htmlspecialchars( basename( $_FILES["avatar"]["name"])). " has been uploaded.";
    echo "The file ". $new_file_name. " has been uploaded";
    echo " <form action='../dashboard.php' method='post'>";
    echo " ";
    echo " <input type='submit' value='To the main menu'>";
  } else {
    echo "Sorry, there was an error uploading your file.";
    echo " <form action='../dashboard.php' method='post'>";
    echo " ";
    echo " <input type='submit' value='To the main menu'>";
  }

}
$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      background-color: #FFCC00;
    }
  </style>
</head>
<body>

</body>
</html>
