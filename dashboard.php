<?php
session_start();

if (isset($_SESSION['email'])){

    $config = include($_SERVER["DOCUMENT_ROOT"]."/teensteaching/config.php");
    $type = $_SESSION['type'];
    $id = $_SESSION['id'];

    //table
    if($_SESSION["type"] == "student"){
        $table = $config['dbt_user_profiles'];
        $fkey = 'user_id';
        $edit_course = false;
    } else {
        $table = $config['dbt_teacher_profiles'];
        $fkey = 'teacher_id';
        $edit_course = true;
    }
    //db connection
    $mysqli = new mysqli ($config['db_host'], $config['db_username'], $config['db_password'], $config['db_database']);


    if (!$mysqli->connect_error) {

        //grab user profile
        $qry="SELECT * FROM $table WHERE $fkey='$id' LIMIT 1";
        $result = $mysqli->query($qry);
        //echo "Selecting";

        if ($result){
            //echo "Result";
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_row($result);
                $profile_id = $row[0];
                $fname = $row[2];
                $lname = $row[3];
                $avatar = $row[4];
                $bio = $row[5];
                //echo "fetched";
                if (empty($avatar)){
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
    
}
else {
    header("Location: login/login-student.php");
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
<nav>
        <div class="nav-color">
            <div class="flex">
                <a href="#"class="burger" href="javascript:void(0);" onclick="myFunction()"><i id="burger" class="fa-solid fa-bars fa-2x fa-fw"></i></a>
                <a href="#"><img src="../static/images/icon2.png" alt=""></a>
            </div>
            <a href="#" class="sign-in">Log out</a>
        </div>
            <div id="navLinks">
                <a href="#news"><i class="fas fa-home fa-2x fa-fw"></i> <p>Home</p></a>
                <a href="#contact"><i class="fa-solid fa-atom fa-2x fa-fw"></i> <p>Subjects</p></a>
                <a href="#"><i class="fa-solid fa-book-open fa-2x fa-fw"></i> <p>Lessons</p></a>
                <a href="#about"><i class="fa-solid fa-gear fa-2x fa-fw"></i> <p>Settings</p></a>
                <a href="#"><i class="fa-regular fa-face-smile fa-2x fa-fw"></i> <p>About us</p></a>
        </div>
        <script>
            function myFunction() {
                var burger = document.getElementById("burger");
                var x = document.getElementById("navLinks");
                if (x.style.display === "block") {
                    x.style.display = "none";
                    burger.className = "fa-solid fa-bars fa-2x fa-fw";
                } else {
                    x.style.display = "block";
                    burger.className = "fa fa-times fa-2x fa-fw";
                }
            } 
        </script>
    </nav>
<h1>Dashboard</h1>
    <div class="profile">

        <div class="f-row">
            <img src="./static/images/default-avatar.png" alt="">
            <div class="f-col">
                <div>
                    <h2 class="name"><?php echo $fname." ".$lname; ?></h2>
                    <p class="type"><?php echo $type; ?></p>
                </div>
                <div class="bio">
                    <hr>
                    <p>Some description here that is long enough to test. I try to be amazing at what I do and teaching helps me afford weekly pizzas.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- <p>Name: <?php// echo $fname." ".$lname; ?></p>
    <p>Type: <?php// echo $type; ?></p>
    <p>Avatar: <img src="<?php//echo $avatar; ?>" alt=""></p>
    <p>Bio: <?php// echo $bio; ?></p> -->
    <!--<a href="./course/view.php">View courses</a> -->
 
<?php //Mokytojui bus matomas jo turiamų sukurtų kursų sąrašas
if($_SESSION['type']=='teacher'){
    $qqry = "SELECT course_difficulty, course_name,course_description FROM Courses WHERE teacher_id='$id'";
    $r = $mysqli->query($qqry);
if($r){
    if(!(mysqli_num_rows($r)>0)){
        echo "There's nothing here";
        //$info_err = "There is no information";
    }
}



echo "<div class='profile'>";
echo"<h2>My courses</h2>";
echo"<hr>";
while($row = mysqli_fetch_array($r)){
    $course_name = $row['course_name'];
    $course_desc = $row['course_description'];
    $course_diff = $row['course_difficulty'];
    //echo $course_name." ".$course_desc." ".$course_diff."<br>";


   //Pridėti kursų korteles, bei padaryt, kad jeigu jokių kortelių nėra, būtų rodomas tekstas "There's nothing here, start by adding new courses"

        echo "<div class='profile'>";
        echo"<a href='#' class='course-link'>";
            echo"<div class='course-card'>";
            echo"<h3>"; echo $course_name; echo"</h3>";
                echo"<p>"; echo $course_desc;echo"</p>";
                echo"<p>"; echo ucfirst($course_diff); echo"<p>";
           echo"</div>";
        echo"</a>";
        echo"</div>";
}
if($edit_course=== true){
    echo '<a href="./course/new.php">Add new course</a>';
}
echo"</div>";
}
$mysqli->close();
?>
<footer>
        <p>Copyright © TeensTeaching 2023</p>
</footer>

</body>
</html>