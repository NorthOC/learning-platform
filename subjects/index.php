<?php

session_start();

$config = include($_SERVER["DOCUMENT_ROOT"]."/teensteaching/config.php");
$info_err = "";

$db = new mysqli ($config['db_host'], $config['db_username'], $config['db_password'], $config['db_database']);

if($db->connect_error){
    die();
}
else{
    $query = "SELECT course_subject, COUNT(*) as count FROM `Courses` GROUP BY course_subject ORDER BY course_subject ASC";
    $result = $db->query($query);
    if($result){
        $arr = [];
        if(!(mysqli_num_rows($result) > 0)){
            //$info_err = "There is no information";
        }
        else{
            while($row = mysqli_fetch_array($result)){
                $arr[] = $row;
            }
        }

    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../static/style.css">
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
            <a href="#" class="sign-in">Sign in</a>
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
    <h1>Subjects</h1>
    <div class="profile" id="courses">
    <div id="tag-cloud">
        <p id="photography">Photography</p>
        <p id="videography">Videography</p>
        <p id="music">Music</p>
        <p id="digital-art">Digital art</p>
        <p id="drawing">Drawing</p>
        <p id="painting">Painting</p>
        <p id="writing">Writing</p>
        <p id="physics">Physics</p>
        <p id="math">Math</p>
        <p id="biology">Biology</p>
        <p id="programming">Programming</p>
        <p id="chemistry">Chemistry</p>
        <p id="engineering">Engineering</p>
        <p id="electronics">Electronics</p>
        <p id="medicine">Medicine</p>
        <p id="history">History</p>
        <p id="psychology">Psychology</p>
        <p id="philosophy">Philosophy</p>
        <p id="economics">Economics</p>
        <p id="entrepreneurship">Entrepreneurship</p>
        <p id="marketing">Marketing</p>
        <p id="sports">Sports</p>
        <p id="nutrition">Nutrition</p>
        <p id="language-learning">Language learning</p>
        <p id="social-skills">Social skills</p>
        <p id="other">Other</p>
    </div>
    <script>
        const data = <?php echo json_encode($arr); ?>;
        console.log(data);
        data.forEach(element => {
            console.log(element[0]);
            tag = document.getElementById(element[0]);
            tag.innerHTML += ` (${element[1]})`;
            tag.className = 'marked';
        });
        tags = document.getElementById('tag-cloud');
        for (let x of Array.from(tags.children)) {
            if (x.className != 'marked'){
                x.innerHTML += " (0)";
            }
        }
    </script>
    </div>
</body>
</html>