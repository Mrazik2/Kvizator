<?php

/** @var \Framework\Support\LinkGenerator $link */
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5">
            <h2>Settings</h2>
            <p>Here you can manage your account.</p>
            <ul>
                <li id="settingsItem"><a href="<?= $link->url("auth.changePassword") ?>" class="btn btn-link">Change Password</a></li>
                <li id="settingsItem"><a href="<?= $link->url("auth.deleteAccount") ?>" class="btn btn-link">Delete Account</a></li>
            </ul>
        </div>
    </div>
