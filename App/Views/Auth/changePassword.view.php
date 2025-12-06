<?php

/** @var string|null $message */
/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */

$view->setLayout('auth');
?>

<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h5 class="card-title text-center">Change Password</h5>
                    <div class="text-center text-danger mb-3" id="message">
                        <?= @$message ?>
                    </div>
                    <form class="form-change-password" method="post" action="<?= $link->url("changePassword") ?>">
                        <div class="form-label-group mb-3">
                            <label for="old_password" class="form-label">Old Password</label>
                            <input name="old_password" type="password" id="old_password" class="form-control" placeholder="Your Old Password"
                                   required autofocus>
                        </div>

                        <div class="form-label-group mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input name="new_password" type="password" id="new_password" class="form-control"
                                   placeholder="New Password" required>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-warning" type="submit" name="submit">Change Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
