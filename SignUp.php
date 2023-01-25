<?php
require_once("templates/header.php");

$userDao->verifyLogged();

?>
<div class="container-fluid" id="SignUp-container">
    <div id="SignUp-form">
        <h2>Register New User</h2>
        <form action="<?= $BASE_URL ?>auth_process.php" method="POST">
            <input type="hidden" name="type" value="register">
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" name="firstName" id="firstName" class="form-control" placeholder="Type your first name">
            </div>
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" name="lastName" id="lastName" class="form-control" placeholder="Type your last name">
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Type your email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Type your password">
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm your Password</label>
                <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" placeholder="Type your password again">
            </div>
            <input type="submit" class="btn btn-primary" value="Create New User">
        </form>
    </div>
</div>


<?php
require_once("templates/footer.php");
?>