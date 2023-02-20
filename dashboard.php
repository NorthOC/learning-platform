<?php
session_start();

if (isset($_SESSION['email'])) {

    $config = include($_SERVER["DOCUMENT_ROOT"] . "/teensteaching/config.php");
    $type = $_SESSION['type'];
    $id = $_SESSION['id'];

    //table
    if ($_SESSION["type"] == "student") {
        $table = $config['dbt_user_profiles'];
        $fkey = 'user_id';
        $edit_course = false;
    } else {
        $table = $config['dbt_teacher_profiles'];
        $fkey = 'teacher_id';
        $edit_course = true;
    }
    //db connection
    $mysqli = new mysqli($config['db_host'], $config['db_username'], $config['db_password'], $config['db_database']);


    if (!$mysqli->connect_error) {

        //grab user profile
        $qry = "SELECT * FROM $table WHERE $fkey='$id' LIMIT 1";
        $result = $mysqli->query($qry);
        //echo "Selecting";

        if ($result) {
            //echo "Result";
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_row($result);
                $profile_id = $row[0];
                $fname = $row[2];
                $lname = $row[3];
                $avatar = $row[4];
                $bio = $row[5];
                //echo "fetched";
                if (empty($avatar)) {
                    $avatar = './static/images/default-avatar.png';
                } else {
                    $avatar = "./static/users/$profile_id/avatar.png";
                }
            }
        } else {
            die('Error: ' . $mysqli->connect_error);
        }
    } else {
        die("Prisijungti nepavyko: " . $mysqli->connect_error);
    }
} else {
    header("Location: login/index.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.css">
    <title>Document</title>
</head>

<body>
    <?php include './partials/nav.php' ?>
    <h1>Dashboard</h1>
    <div class="profile">
        <div class="f-row">
            <img src="./static/images/default-avatar.png" alt="">
            <div class="f-col">
                <div>
                    <h2 class="name"><?php echo $fname . " " . $lname; ?></h2>
                    <p class="type"><?php echo $type; ?></p>
                </div>
                <div class="bio">
                    <hr>
                    <p><?php echo empty($bio); ?></p>
                    <a href="edit-profile.php">Edit profile</a>
                </div>
            </div>
        </div>
    </div>

    <?php //Mokytojui bus matomas jo turiamų sukurtų kursų sąrašas
    if ($_SESSION['type'] == 'teacher') {
        $qqry = "SELECT id, course_difficulty, course_name, course_price, course_type FROM Courses WHERE teacher_id='$id'";
        $r = $mysqli->query($qqry);
        if ($r) {
            if (!(mysqli_num_rows($r) > 0)) {
                echo "<p>There's nothing here</p>";
                //$info_err = "There is no information";
            } else {
                echo "<div class='profile'>";
                echo "<h2>My courses <em class='clarifier'>(edit a course by clicking on it)</em></h2>";
                echo "<hr>";
                while ($row = mysqli_fetch_array($r)) {
                    $course_name = $row['course_name'];
                    $course_price = $row['course_price'];
                    $course_diff = $row['course_difficulty'];
                    $course_type = $row['course_type'];
                    //echo $course_name." ".$course_desc." ".$course_diff."<br>";


                    //Pridėti kursų korteles, bei padaryt, kad jeigu jokių kortelių nėra, būtų rodomas tekstas "There's nothing here, start by adding new courses"
                    echo "<a href='./course/view.php?id=".$row['id']."'"." class='course-link'>";
                    echo "<div class='course-card'>";
                    echo "<h3>" . $course_name . "</h3>";
                    echo "<p>" . $course_type . "</p>";
                    echo "<p>" . ucfirst($course_diff) . "</p>";
                    echo "<p>€" . $course_price . "</p>";
                    echo "</div>";
                    echo "</a>";
                }
                if ($edit_course === true) {
                    echo '<a href="./course/new.php">Create a new course</a>';
                }
                echo "</div>";
            }
            $mysqli->close();
        }
        // studentui tas pats
    } else {
        $qqry = "SELECT course_id FROM Purchased_courses WHERE user_id='$id'";
        $r = $mysqli->query($qqry);
        if ($r) {
            echo "<div class='profile'>";
            echo "<h2>My courses <em class='clarifier'>(view a course by clicking on it)</em></h2>";
            echo "<hr>";
            if (!(mysqli_num_rows($r) > 0)) {
                echo "<p>There's nothing here</p>";
                //$info_err = "There is no information";
            } else {
                while ($row = mysqli_fetch_array($r)) {
                    $course_id = $row['course_id'];
                    $qqry = "SELECT id, course_name, course_type, course_subject FROM Courses WHERE id='$course_id' LIMIT 1";
                    $result = $mysqli->query($qqry);
                    if ($result) {
                        if (!(mysqli_num_rows($result) > 0)) {
                            echo "<p>An error has occured. Please contact the administrator.</p>";
                        } else {
                            $row_course = mysqli_fetch_array($result);
                            $course_name = $row_course['course_name'];
                            $course_type = $row_course['course_type'];
                            $course_subject = $row_course['course_subject'];

                            echo "<a href='../course/view.php?id=".$row['id']."'"." class='course-link'>";
                            echo "<div class='course-card'>";
                            echo "<h3>" . $course_name . "</h3>";
                            echo "<p>" . $course_type . "</p>";
                            echo "<p>" . ucfirst($course_subject) . "<p>";
                            echo "</div>";
                            echo "</a>";
                        }
                    }
                }
            }
            echo '<a href="./courses">Add a new course now!</a>';
            echo "</div>";
            $mysqli->close();
        }
    }
    ?>
    <footer>
        <p>Copyright © TeensTeaching 2023</p>
    </footer>

</body>

</html>