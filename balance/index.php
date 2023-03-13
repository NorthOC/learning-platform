<?php
session_start();

$BANK_NUMBER = "LT867044060008094364";
$NAME = "Denis Lisunov";
$BANK = "SEB";

if (!isset($_SESSION['email']) || !isset($_SESSION['id'])) {
  header("Location: ../login/index.php");
  die();
}

$user_id = $_SESSION['id'];
$user_type = $_SESSION['type'];

if ($user_type == 'teacher'){
  $table = "Teachers";
} else {
  $table = "Users";
}

$config = include($_SERVER["DOCUMENT_ROOT"] . "/teensteaching/config.php");

//db connection
$mysqli = new mysqli($config['db_host'], $config['db_username'], $config['db_password'], $config['db_database']);
$qry = "SELECT * FROM $table WHERE id='$user_id' LIMIT 1";

if ($mysqli->connect_error) {
  die("Connection error: " . $mysqli->connect_error);
}

$result = $mysqli->query($qry);

if (!$result) {
  die('Error: ' . $mysqli->connect_error);
} 
elseif (mysqli_num_rows($result) != 1) {
  die();
}

$user_info = mysqli_fetch_array($result);
$transaction_code = substr($user_info['password'],8,7);
$user_info['password'] = "";
$credit = $user_info['credit'];

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']) && $user_type == 'teacher') {
  $withdraw_value = $_POST['demo'];
  if (!is_numeric($withdraw_value)){
    die();
  }
  if ($credit < $withdraw_value){
    die();
  }
  $qry = "UPDATE $table SET credit = credit-'$withdraw_value' WHERE id='$user_id'";
  $result = $mysqli->query($qry);

  if (!$result) {
    die('Error: ' . $mysqli->connect_error);
  }

  $qry = "INSERT INTO Transactions (amount, teacher_id) VALUES ('$withdraw_value', '$user_id')";
  $result = $mysqli->query($qry);

  if (!$result) {
    die('Error: ' . $mysqli->connect_error);
  }

  $qry = "SELECT credit FROM $table WHERE id='$user_id' LIMIT 1";

  if ($mysqli->connect_error) {
    die("Connection error: " . $mysqli->connect_error);
  }
  
  $result = $mysqli->query($qry);
  
  if (!$result) {
    die('Error: ' . $mysqli->connect_error);
  } 
  elseif (mysqli_num_rows($result) != 1) {
    die();
  }
  
  $credit_info = mysqli_fetch_array($result);
  $credit = $user_info['credit'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../partials/stylesheets.php'; ?>
    <title>Balance</title>
</head>

<body>
  <?php include '../partials/nav.php'; ?>
  <?php if ($user_type != 'teacher'){?>
  <h1>Deposit</h2>

  <p>Make a transaction to our bank account and we will top up your Teensteaching account with that amount! (may take up to 3 business days)</p>
  <p>Don't forget to copy and paste the transaction code into the payment information field!</p>

  <h2>Bank details:</h2>
  <div class="bank-details">
    <p>Recipient: <?php echo $NAME; ?></p>
    <p><?php echo $BANK_NUMBER; ?></p>
    <p>Bank: <?php echo $BANK; ?></p>
    <p>Transaction code: <?php echo $transaction_code; ?></p>
  </div>

  <p>To make a withdrawal, please contact the website owner at: sellmethebots@gmail.com</p>

  <?php }else{ ?>
  <h1>Withdrawal</h2>

  <p>Submit a withdrawal and you will receive the money (within 3 business days) into the specified bank account.</p>

  <h2>Form</h2>

  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  
    <div class="form-group">
      <label for="slider">Amount:</label>
      <div class="slidecontainer">
        <input name='slider' type="range" min="0" step="0.01" max="<?php echo $credit; ?>" value="<?php echo $credit; ?>" class="slider" id="myRange">
      </div>
    </div>
    <p>Value: <input id="demo" name='demo' value="<?php echo $credit; ?>"></input></p>
    <div class="form-group">
        <input type="submit" name="submit" class="btn btn-primary" value="submit"></input>
    </div>
  </form>


  <?php }; ?>



  <?php include '../partials/footer.php'; ?>

<script>
  var slider = document.getElementById("myRange");
  var output = document.getElementById("demo");
  output.innerHTML = slider.value;

  slider.oninput = function() {
    output.innerHTML = this.value;
    output.value = this.value;
  }
  
  output.onfocusout = function(){
    if(!isNaN(output.value)){
      output.value = slider.max;
      output.innerHTML = slider.max;
    } 
    else if(output.value > slider.max){
        output.value = slider.max;
        output.innerHTML = slider.max;
        slider.value = slider.max;
    } 
    else if(output.value < 0){
        output.value = 0;
        output.innerHTML = 0;
        slider.value = 0;
    }
    else {
        slider.value = output.value;
      }
    }
</script>
</body>
</html>
