<?php 
session_start();
if (isset($_SESSION['email'])){
    header("Location: dashboard.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./static/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  <?php include './partials/nav.php'; ?>
    <main>
        <h1>Learn new things everyday!</h1>
        <div class="homepage-card">
            <img src="./static/images/stock-p-one.jpg" alt="">
            <div class="flex">
                <h2>LEARN</h2>
                <p>Learn or repeat subject's topics! Meet new people that are just like you.</p>
                <a href="./register/to-learn/">Get started!</a>
            </div>
        </div>
        <div class="homepage-card">
            <img src="./static/images/stock-p-two.jpg" alt="">
            <div class="flex">
                <h2>TEACH</h2>
                <p>Help others learn and earn extra money!</p>
                <a href="./register/to-teach/">Get started!</a>
            </div>
        </div>
    </main>
    <?php include './partials/footer.php'; ?>
</body>
</html>