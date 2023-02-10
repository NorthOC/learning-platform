<?php
session_start();

$config = include($_SERVER["DOCUMENT_ROOT"] . "/teensteaching/config.php");
$has_courses = false;

$db = new mysqli($config['db_host'], $config['db_username'], $config['db_password'], $config['db_database']);
if ($db->connect_error) {
    die();
} else {
    if (isset($_GET['filter'])) {
        $filter = test_input($_GET['filter']);
        if (!empty($filter)){
            $qry = "SELECT * FROM Courses WHERE course_subject = '$filter'";
        } else {
            $qry = "SELECT * FROM Courses";
        }
    } else{
        $qry = "SELECT * FROM Courses";
    }
    $result = $db->query($qry);
    if ($result) {
        if ((mysqli_num_rows($result) > 0)) {
            $has_courses = true;
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
    <?php include '../partials/stylesheets.php'; ?>
    <title>List of all courses</title>
</head>

<body>
    <?php include '../partials/nav.php'; ?>
    <h1>Courses</h1>
    <div class="profile" id="courses">
        <div class="headers">
            <p>Course Name</p>
            <p>Lesson Type</p>
            <p>Subject</p>
            <p>Difficulty</p>
            <p>Price</p>
            <p>Rating</p>
        </div>


        <?php
        if ($has_courses) {
            $count = 0;
            while ($row = mysqli_fetch_array($result)) {
                $count += 1;
                echo "<a href='../course/view.php?id=".$row['id']."'"." class='course-link'>";
                echo "<div class='course-card'>";
                echo "<h3>".$count.". ".$row['course_name']."</h3>";
                echo "<p>".$row['course_type']."</p>";
                echo "<p>".$row['course_subject']."</p>";
                echo "<p>".$row['course_difficulty']."</p>";
                echo "<p>€".$row['course_price']."</p>";
                echo "<div class='rating'>";
                echo "<p>🌕🌕🌕🌕🌑</p>";
                echo "<p>(100)</p>";
                echo "</div>";
                echo "</div>";
                echo "</a> ";
            }
        } else {
            echo "<p>There are no courses.</p>";
        }
            
        ?>
    </div>
    <?php include '../partials/footer.php'; ?>
</body>
</html>