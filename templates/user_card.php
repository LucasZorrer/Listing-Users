<?php

if (empty($user->image)) {
    $user->image = "user.png";
}

?>

<div class="row" id="container-card">
    <div class="col-sm-6">
        <div class="card-body">
            <h5 class="card-title"><?= $user->firstName . " " . $user->lastName ?></h5>
            <?php if($user->bio === ""): ?>
            <p class="card-text">The bio is empty :(</p>
            <?php else: ?>
            <p class="card-text"><?= $user->bio ?></p>
            <?php endif; ?>
            <p class="card-text"><?= $user->email ?></p>
        </div>
    </div>
    <div class="col-sm-6">
        <div id="profile-image-container" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $user->image ?>')"></div>
    </div>
</div>