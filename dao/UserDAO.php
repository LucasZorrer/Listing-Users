<?php

include_once("models/User.php");
include_once("models/Message.php");

class UserDao implements UserDAOINTERFACE
{

    private $conn;
    private $url;
    private $message;

    public function __construct(PDO $conn, $url)
    {
        $this->conn = $conn;
        $this->url = $url;
        $this->message = new Message($url);
    }

    public function buildUser($data)
    {

        $user = new User();

        $user->id = $data["id"];
        $user->firstName = $data["firstName"];
        $user->lastName = $data["lastName"];
        $user->email = $data["email"];
        $user->password = $data["password"];
        $user->image = $data["image"];
        $user->bio = $data["bio"];
        $user->token = $data["token"];

        return $user;
    }
    public function create(User $user, $authUser = false)
    {

        $stmt = $this->conn->prepare("INSERT INTO users (firstName, lastName, email, password, image, bio, token)
        VALUES (:firstName, :lastName, :email, :password, :image, :bio, :token)");

        $stmt->bindParam(":firstName", $user->firstName);
        $stmt->bindParam(":lastName", $user->lastName);
        $stmt->bindParam(":email", $user->email);
        $stmt->bindParam(":password", $user->password);
        $stmt->bindParam(":image", $user->image);
        $stmt->bindParam(":bio", $user->bio);
        $stmt->bindParam(":token", $user->token);

        $stmt->execute();

        if ($authUser) {
            $this->setTokenToSession($user->token);
        }
    }
    public function update(User $user, $redirect = true)
    {

        $stmt = $this->conn->prepare("UPDATE users SET
            firstName = :firstName,
            lastName = :lastName,
            email = :email,
            password = :password,
            image = :image,
            bio = :bio,
            token = :token
            WHERE id = :id
        ");

        $stmt->bindParam(":firstName", $user->firstName);
        $stmt->bindParam(":lastName", $user->lastName);
        $stmt->bindParam(":email", $user->email);
        $stmt->bindParam(":password", $user->password);
        $stmt->bindParam(":image", $user->image);
        $stmt->bindParam(":bio", $user->bio);
        $stmt->bindParam(":token", $user->token);
        $stmt->bindParam(":id", $user->id);

        $stmt->execute();

        if ($redirect) {
            $this->message->setMessage("Data Account updated successfully", "success", "profile.php");
        }
    }
    public function verifyToken($protected = false)
    {

        if (!empty($_SESSION["token"])) {
            $token = $_SESSION["token"];
            $user = $this->findByToken($token);

            if ($user) {
                return $user;
            } else if ($protected) {
                $this->message->setMessage(
                    "Login to access in this page!",
                    "error",
                    "index.php"
                );
            }
        } else if ($protected) {
            $this->message->setMessage(
                "Login to access in this page!",
                "error",
                "index.php"
            );
        }
    }
    public function verifyLogged()
    {
        $token = $_SESSION["token"];
        $user = $this->findByToken($token);
        if ($user) {
            $this->message->setMessage(
                "You are already logged.",
                "error",
                "index.php"
            );
        }
    }
    public function setTokenToSession($token, $redirect = true)
    {

        $_SESSION["token"] = $token;

        if ($redirect) {
            $this->message->setMessage("Welcome!", "success", "index.php");
        }
    }
    public function authenticateUser($email, $password)
    {

        $user = $this->findByEmail($email);

        if ($user) {

            if (password_verify($password, $user->password)) {

                $token = $user->generateToken();
                $this->setTokenToSession($token);

                $user->token = $token;
                $this->update($user, false);

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function getAllUsers()
    {
        $users = [];

        $stmt = $this->conn->prepare("SELECT * FROM users ORDER BY id DESC");
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $usersArray = $stmt->fetchAll();

            foreach ($usersArray as $user) {
                $users[] = $this->buildUser($user);
            }
        }

        return $users;
    }
    public function findByToken($token)
    {

        if ($token != "") {

            $stmt = $this->conn->prepare("SELECT * FROM users WHERE token = :token");
            $stmt->bindParam(":token", $token);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {

                $data = $stmt->fetch();
                $user = $this->buildUser($data);

                return $user;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function findByEmail($email)
    {

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $data = $stmt->fetch();

            $user = $this->buildUser($data);

            return $user;
        } else {
            return false;
        }
    }
    public function destroyToken()
    {

        $_SESSION["token"] = "";

        $this->message->setMessage("You have successfully logged out!", "success", "index.php");
    }
    public function changePassword(User $user)
    {

        $stmt = $this->conn->prepare("UPDATE users SET password = :password WHERE id = :id");

        $stmt->bindParam(":password", $user->password);
        $stmt->bindParam(":id", $user->id);

        $stmt->execute();

        $this->message->setMessage("Password successfully changed", "success", "profile.php");
    }
}
