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
    <?php include '../partials/stylesheets.php'; ?>
    <title>Document</title>
</head>
<body>
    <?php include '../partials/nav.php'; ?>
    <h1>Subjects</h1>
    <div class="profile" id="courses">
    <div id="tag-cloud">
        <a href="<?php echo SCRIPT_ROOT; ?>/courses?filter=biology">
            <p id="biology">Biology</p>
        </a>
        <a href="<?php echo SCRIPT_ROOT; ?>/courses?filter=chemistry">
            <p id="chemistry">Chemistry</p>
        </a>
        <a href="<?php echo SCRIPT_ROOT; ?>/courses?filter=digital-art">
            <p id="digital-art">Digital art</p>
        </a>
        <a href="<?php echo SCRIPT_ROOT; ?>/courses?filter=drawing">
            <p id="drawing">Drawing</p>
        </a>
        <a href="<?php echo SCRIPT_ROOT; ?>/courses?filter=economics">
            <p id="economics">Economics</p>
        </a>
        <a href="<?php echo SCRIPT_ROOT; ?>/courses?filter=electronics">
            <p id="electronics">Electronics</p>
        </a>
        <a href="<?php echo SCRIPT_ROOT; ?>/courses?filter=engineering">
            <p id="engineering">Engineering</p>
        </a>
        <a href="<?php echo SCRIPT_ROOT; ?>/courses?filter=entrepreneurship">
            <p id="entrepreneurship">Entrepreneurship</p>
        </a>
        <a href="<?php echo SCRIPT_ROOT; ?>/courses?filter=history">
            <p id="history">History</p>
        </a>
        <a href="<?php echo SCRIPT_ROOT; ?>/courses?filter=language-learning">
            <p id="language-learning">Language learning</p>
        </a>
        <a href="<?php echo SCRIPT_ROOT; ?>/courses?filter=marketing">
            <p id="marketing">Marketing</p>
        </a>
        <a href="<?php echo SCRIPT_ROOT; ?>/courses?filter=math">
            <p id="math">Math</p>
        </a>
        <a href="<?php echo SCRIPT_ROOT; ?>/courses?filter=medicine">
            <p id="medicine">Medicine</p>
        </a>
        <a href="<?php echo SCRIPT_ROOT; ?>/courses?filter=music">
            <p id="music">Music</p>
        </a>
        <a href="<?php echo SCRIPT_ROOT; ?>/courses?filter=nutrition">
            <p id="nutrition">Nutrition</p>
        </a>
        <a href="<?php echo SCRIPT_ROOT; ?>/courses?filter=other">
            <p id="other">Other</p>
        </a>
        <a href="<?php echo SCRIPT_ROOT; ?>/courses?filter=painting">
            <p id="painting">Painting</p>
        </a>
        <a href="<?php echo SCRIPT_ROOT; ?>/courses?filter=philosophy">
            <p id="philosophy">Philosophy</p>
        </a>
        <a href="<?php echo SCRIPT_ROOT; ?>/courses?filter=photography">
            <p id="photography">Photography</p>
        </a>
        <a href="<?php echo SCRIPT_ROOT; ?>/courses?filter=physics">
            <p id="physics">Physics</p>
        </a>
        <a href="<?php echo SCRIPT_ROOT; ?>/courses?filter=programming">
            <p id="programming">Programming</p>
        </a>
        <a href="<?php echo SCRIPT_ROOT; ?>/courses?filter=psychology">
            <p id="psychology">Psychology</p>
        </a>
        <a href="<?php echo SCRIPT_ROOT; ?>/courses?filter=social-skills">
            <p id="social-skills">Social skills</p>
        </a>
        <a href="<?php echo SCRIPT_ROOT; ?>/courses?filter=sports">
            <p id="sports">Sports</p>
        </a>
        <a href="<?php echo SCRIPT_ROOT; ?>/courses?filter=videography">
            <p id="videography">Videography</p>
        </a>
        <a href="<?php echo SCRIPT_ROOT; ?>/courses?filter=writing">
            <p id="writing">Writing</p>
        </a>
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
        tags = Array.from(document.getElementById('tag-cloud').children);
        for (let x of tags) {
            if (x.firstElementChild.className != 'marked'){
                x.firstElementChild.style.display = "none";
            }
        }
    </script>
    </div>
    <?php include '../partials/footer.php'; ?>
</body>
</html>