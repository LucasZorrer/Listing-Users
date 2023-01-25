<?php

class User
{

    public $id;
    public $firstName;
    public $lastName;
    public $email;
    public $password;
    public $image;
    public $bio;
    public $token;

    public function generateToken()
    {
        return bin2hex(random_bytes(50));
    }
    public function generatePassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    public function getFullName($user)
    {
        $fullName = $user->firstName . " " . $user->lastName;
        return $fullName;
    }
    public function imageGenerateName($ext)
    {
        return bin2hex(random_bytes(60)) . $ext;
    }
}

interface UserDAOINTERFACE
{
    public function buildUser($data);
    public function create(User $user, $authUser = false);
    public function update(User $user, $redirect = true);
    public function verifyToken($protected = false);
    public function verifyLogged();
    public function setTokenToSession($token, $redirect = true);
    public function authenticateUser($email, $password);
    public function getAllUsers();
    public function findByToken($token);
    public function findByEmail($email);
    public function destroyToken();
    public function changePassword(User $user);
}
