<?php

require_once("models/Message.php");
require_once("models/User.php");
require_once("dao/UserDAO.php");
require_once("db.php");
require_once("globals.php");

$message = new Message($BASE_URL);
$userDao = new UserDao($conn, $BASE_URL);

$type = filter_input(INPUT_POST, "type");

if ($type === "register") {

    $firstName = filter_input(INPUT_POST, "firstName");
    $lastName = filter_input(INPUT_POST, "lastName");
    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");
    $confirmPassword = filter_input(INPUT_POST, "confirmPassword");

    if ($firstName && $lastName && $email && $password) {
        if ($userDao->findByEmail($email) === false) {
            if ($password === $confirmPassword) {

                $user = new User();

                $userToken = $user->generateToken();
                $finalPassword = $user->generatePassword($password);

                $user->firstName = $firstName;
                $user->lastName = $lastName;
                $user->email = $email;
                $user->password = $finalPassword;
                $user->token = $userToken;

                $auth = true;

                $userDao->create($user, $auth);
            } else {
                $message->setMessage("The passwords must be the same!", "error", "back");
            }
        } else {
            $message->setMessage("Email already used", "error", "back");
        }
    } else {
        $message->setMessage("Complete all the fields below", "error", "back");
    }
} else if ($type === "login") {

    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");

    if ($userDao->authenticateUser($email, $password)) {
        $message->setMessage("Welcome!", "success", "index.php");
    } else {
        $message->setMessage("Wrong email or password.", "error", "back");
    }
} else {
    $message->setMessage("Invalid Informations!", "error", "index.php");
}
