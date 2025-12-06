<?php

/** @var \Framework\Support\LinkGenerator $link */
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5">
            <h1>Settings</h1>
            <p>Here you can change your settings.</p>
            <ul>
                <li><a href="<?= $link->url("auth.changePassword") ?>">Change Password</a></li>
                <li><a href="<?= $link->url("auth.deleteAccount") ?>">Delete Account</a></li>
            </ul>
        </div>
    </div>
