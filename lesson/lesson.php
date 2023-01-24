<?php
session_start();

if(!isset($_SESSION['email'])){
    header('Location: ../login/login-student.php');
};
if(isset($_GET['course_id'])){
    header('Location: ../dashboard.php');
};
$course_id = $_GET['course_id'];
$data = $_POST['json'];
$config = include($_SERVER["DOCUMENT_ROOT"]."/teensteaching/config.php");
function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
};
$title = $description = $link = "";
$titleErr = $descriptionErr = $linkErr = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){
  $json = $_POST["json"];
  $decoded_info = json_decode($json,true);
//  print_r($decoded_info);

/*testing output

 echo "<br>";
 echo $decoded_info[0]['title'];
 echo "<br>";
 echo $decoded_info[0]['desc'];
 echo "<br>";
 echo $decoded_info[0]['link'];
 echo "<br>";

foreach($decoded_info as $test){
    echo $test['title'];
}
*/

$title = test_input($_POST['title']);
$description = test_input($_POST['desc']);
$link = test_input($_POST['link']);

$continue = true;

if(empty($title)){
    $continue = false;
    $titleErr = "Title field is empty";
}
else{
    if(strlen($title)<1){
        $continue = false;
        $titleErr = "Title name has to be longer than one character";
    }
}

if(empty($description)){
    $continue = false;
    $descriptionErr = "Description field is empty";
}


if(empty($link)){
    $continue = false;
    $linkErr = "Video link field is empty";
}

if($continue){
    $db = new mysqli ($config['db_host'], $config['db_username'], $config['db_password'], $config['db_database']);
    if($db->connect_error){
        die("Connection failed: ". $db->connect_error);
    }
    $qry = "SELECT * FROM Courses WHERE id = '$course_id'";
    $result = $db->query($qry);
    if($result){
        if(!(mysqli_num_rows($result) > 0)){
            header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
        }
        else{
            $row = mysqli_fetch_row($result);
        }
}

$sql = "UPDATE Courses SET json_blob = '$data' WHERE id = '$course_id'";
if($db->query($sql) === TRUE){
    echo "Record updated successfully";
}
else{
    echo "Error updating record: " . $db->error; 
}

}
$db->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="form" name="Forma">
        <input type="hidden" name="json" id="json">
        <button onclick="createBlock()" id="new-block" type="button">New lesson</button>
        <button onclick="CheckingInfo()" id="new-block" type="button">Submit</button>
    </form>

    <script>
        function createBlock() {
            const newNode = document.createElement("div");
            newNode.classList.add("newclass");
            const title = document.createElement("label");
            title.innerHTML = "Lesson Title:";
            const title_input = document.createElement("input");
            title_input.classList.add("titleInput");

            const desc = document.createElement("label");
            desc.innerHTML = "Lesson Description:";
            const desc_input = document.createElement("input");
            desc_input.classList.add("descInput");

            const link = document.createElement("label");
            link.innerHTML = "Lesson Video";
            const link_desc = document.createElement("input");
            link_desc.classList.add("videoLink");

            newNode.appendChild(title);
            newNode.appendChild(title_input);

            newNode.appendChild(desc);
            newNode.appendChild(desc_input);

            newNode.appendChild(link);
            newNode.appendChild(link_desc);

            form = document.getElementById("form");
            btn = document.getElementById("new-block");
            form.insertBefore(newNode, btn);

        }
            
     function CheckingInfo(){
        var elements = document.getElementsByClassName("newclass");
        var json = {};
       for(var x=0;x<elements.length;x++){
        tempjson = {};
        //console.log(elements[x]);
        var tempVar = elements[x];
        var title = tempVar.getElementsByClassName("titleInput");
        var desc = tempVar.getElementsByClassName("descInput");
        var link = tempVar.getElementsByClassName("videoLink");
        tempjson['title'] = title[0].value;
        tempjson['desc'] = desc[0].value;
        tempjson['link'] = link[0].value;
        json[x] = tempjson;
        //console.log(title[0].value);
       // console.log(desc[0].value);
       // console.log(link[0].value);
}
        inpt = document.getElementById("json");
        inpt.value = JSON.stringify(json);
        document.Forma.submit();
 }           
    </script>
</body>
</html>
