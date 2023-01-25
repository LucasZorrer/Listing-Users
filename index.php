<?php
require_once("templates/header.php");
require_once("dao/UserDAO.php");

$userDao = new UserDao($conn, $BASE_URL);

$getUsers = $userDao->getAllUsers();

?>

<div id="main-container" class="container-fluid">
    <?php foreach ($getUsers as $user) : ?>
        <?php require("templates/user_card.php"); ?>
    <?php endforeach; ?>
    <?php if (count($getUsers) === 0) : ?>
        <p class="empty-list">There aren't registered users yet.</p>
    <?php endif; ?>
</div>
<?php
require_once("templates/footer.php");
?>