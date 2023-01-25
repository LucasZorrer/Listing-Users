<?php
require_once("templates/header.php");

$userDao->verifyLogged();
?>
<div class="container-fluid" id="Login-container">
    <div id="Login-form">
        <h2>Login</h2>
        <form action="<?= $BASE_URL ?>auth_process.php" method="POST">
            <input type="hidden" name="type" value="login">
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Type your email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Type your password">
            </div>
            <input type="submit" class="btn btn-primary" value="Login">
        </form>
    </div>
</div>


<?php
require_once("templates/footer.php");
?>