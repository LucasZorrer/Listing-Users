<?php
require_once("templates/header.php");
require_once("models/User.php");
require_once("dao/UserDAO.php");

$user = new User();

$userDao = new UserDao($conn, $BASE_URL);

$userData = $userDao->verifyToken(true);



$fullName = $user->getFullName($userData);

if ($userData->image == "") {
    $userData->image = "user.png";
}


?>
<div class="container-fluid edit-profile-page" id="main-container">
    <div class="col-md-12">
        <form action="<?= $BASE_URL ?>user_process.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="type" value="update">
            <input type="hidden" name="id" value="<?= $userData->id ?>">
            <div class="row">
                <div class="col-md-4">
                    <h1><?= $fullName ?></h1>
                    <p class="page-description">Change your data in the form below.</p>
                    <div class="form-group">
                        <label for="firstName">First Name:</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Type your first name." value="<?= $userData->firstName ?>">
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name:</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Type your last name" value="<?= $userData->lastName ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="text" readonly class="form-control disabled" id="email" name="email" placeholder="Type your email" value="<?= $userData->email ?>">
                    </div>
                    <input type="submit" class="btn card-btn" value="Change">
                </div>
                <div class="col-md-4">
                    <div id="profile-image-container" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $userData->image ?>')"></div>
                    <div class="form-group">
                        <label for="image">Image:</label>
                        <input type="file" class="form-control-file" name="image">
                    </div>
                    <div class="form-group">
                        <label for="bio">About You:</label>
                        <textarea name="bio" class="form-control" id="bio" rows="5" placeholder="Write something about you..."><?= $userData->bio ?></textarea>
                    </div>
                </div>
            </div>

        </form>
        <div class="row" id="change-password-container">
            <div class="col-md-4">
                <h2>Change Password</h2>
                <p class="page-description">Type your new password and confirm to change it.</p>
                <form action="<?= $BASE_URL ?>user_process.php" method="POST">
                    <input type="hidden" name="type" value="changePassword">
                    <div class="form-group">
                        <label for="password">New Password:</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Type your password">
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm your new password:</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Type your password again">
                    </div>
                    <input type="submit" class="btn card-btn" value="Change Password">
                </form>
            </div>
        </div>
    </div>
</div>


<?php
require_once("templates/footer.php");
?>