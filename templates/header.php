<?php

require_once("globals.php");
require_once("db.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");

$message = new Message($BASE_URL);

$flassMessage = $message->getMessage();

if (!empty($flassMessage)) {
    $message->clearMessage();
}

$userDao = new UserDao($conn, $BASE_URL);
$userData = $userDao->verifyToken(false);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listing Users</title>
    <link rel="short icon" href="<?= $BASE_URL ?>img/svg/user.svg" />
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.3/css/bootstrap.css" integrity="sha512-bR79Bg78Wmn33N5nvkEyg66hNg+xF/Q8NA8YABbj+4sBngYhv9P8eum19hdjYcY7vXk/vRkhM3v/ZndtgEXRWw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- FONT AWESONME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS do projeto-->
    <link rel="stylesheet" href="<?= $BASE_URL ?>css/styles.css">
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</head>

<body>
    <header>
        <nav>
            <div class="navbar-container">
                <?php if ($userData) : ?>
                    <a href="<?= $BASE_URL ?>" class="navbar-brand">Home</a>
                    <a href="<?= $BASE_URL ?>profile.php" class="navbar-brand"><?= $userData->firstName ?></a>
                    <a href="<?= $BASE_URL ?>logout.php" class="navbar-brand">LogOut</a>
                <?php else : ?>
                    <a href="<?= $BASE_URL ?>" class="navbar-brand">Home</a>
                    <a href="<?= $BASE_URL ?>SignUp.php" class="navbar-brand">Sign Up</a>
                    <a href="<?= $BASE_URL ?>Login.php" class="navbar-brand">Login</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>
    <?php if (!empty($flassMessage)) : ?>
        <div class="msg-container">
            <p class="msg <?= $flassMessage["type"] ?>"><?= $flassMessage["msg"] ?></p>
        </div>
    <?php endif; ?>