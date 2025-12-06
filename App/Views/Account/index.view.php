<?php

/** @var \Framework\Support\LinkGenerator $link */
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5">
            <h1>Account Dashboard</h1>
            <p>Welcome to your account dashboard. Here you can manage your account settings and view your activity.</p>
            <ul>
                <li><a href="<?= $link->url("account.settings") ?>">Account Settings</a></li>
                <li><a href="<?= $link->url("auth.logout") ?>">Log Out</a></li>
            </ul>
        </div>
    </div>