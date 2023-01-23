<?php
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
  $test = $_POST["json"];
  $testing = json_decode($test);
  echo $testing[0];

 // $description = test_input($_POST[""]);
 // $link = test_input($_POST[""]);

//$continue = true;














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

    <p id="testing"></p>

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
        var jarr = [];
        var json = {};
       for(var x=0;x<elements.length;x++){
        tempjson = {};
        console.log(elements[x]);
        var tempVar = elements[x];
        var title = tempVar.getElementsByClassName("titleInput");
        var desc = tempVar.getElementsByClassName("descInput");
        var link = tempVar.getElementsByClassName("videoLink");
        tempjson['title'] = title[0].value;
        tempjson['desc'] = desc[0].value;
        tempjson['link'] = link[0].value;
        var arr = [];
        arr.push(tempjson);
        json[x] = arr;
        //console.log(title[0].value);
       // console.log(desc[0].value);
       // console.log(link[0].value);
}
         jarr.push(json);
        inpt = document.getElementById("json");
        inpt.value = JSON.stringify(json);
        document.Forma.submit();
 }           
    </script>



</body>
</html>
