<?php

require_once("models/Message.php");
require_once("models/User.php");
require_once("dao/UserDAO.php");
require_once("db.php");
require_once("globals.php");

$message = new Message($BASE_URL);

$userDao = new UserDao($conn, $BASE_URL);

$type = filter_input(INPUT_POST, "type");


if ($type === "update") {

    $userData = $userDao->verifyToken();

    $firstName = filter_input(INPUT_POST, "firstName");
    $lastName = filter_input(INPUT_POST, "lastName");
    $email = filter_input(INPUT_POST, "email");
    $bio = filter_input(INPUT_POST, "bio");


    $user = new User();

    $userData->firstName = $firstName;
    $userData->lastName = $lastName;
    $userData->email = $email;
    $userData->bio = $bio;

    if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

        $image = $_FILES["image"];
        $imageTypes = ["image/jpeg", "image/jpg", "image/png", "image/gif", "image/bmp"];
        $jpgArray = ["image/jpeg", "image/jpg"];
        $ext = strtolower(substr($image["name"], -4));


        //Checagem de tipo de imagem

        if (in_array($image["type"], $imageTypes)) {

            if ($ext == ".jpg") {
                $imageFile = imagecreatefromjpeg($image["tmp_name"]);
            } else if ($ext == ".png") {
                $imageFile = imagecreatefrompng($image["tmp_name"]);
            }

            $imageName = $user->imageGenerateName($ext);

            imagejpeg($imageFile, "./img/users/" . $imageName, 100);

            $userData->image = $imageName;
        } else {
            $message->setMessage("Invalid type of image, try png or jpg", "error", "back");
        }
    }

    $userDao->update($userData);
} else if ($type === "changePassword") {

    $password = filter_input(INPUT_POST, "password");
    $confirmPassword = filter_input(INPUT_POST, "confirmPassword");

    $userData = $userDao->verifyToken();

    $id = $userData->id;

    if ($password === $confirmPassword) {
        $user = new User();

        $finalPassword = $user->generatePassword($password);

        $user->password = $finalPassword;
        $user->id = $id;

        $userDao->changePassword($user);
    } else {
        $message->setMessage("The passwords must be the same!", "error", "back");
    }
} else {
    $message->setMessage("Invalid Informations!", "error", "index.php");
}
