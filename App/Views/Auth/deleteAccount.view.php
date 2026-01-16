<?php

/** @var string|null $message */
/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */

?>

<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h5 class="card-title text-center">Delete Account</h5>
                    <div class="text-center text-danger mb-3" id="message">
                        <?= @$message ?>
                    </div>
                    <form class="form-delete-account" method="post" action="<?= $link->url("deleteAccount") ?>">
                        <div class="form-label-group mb-3">
                            <label for="password" class="form-label">Confirm Password</label>
                            <input name="password" type="password" id="password" class="form-control"
                                   placeholder="Password" required autofocus>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-danger" type="submit" name="submit">Delete Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>