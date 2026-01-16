<?php

/** @var string $contentHTML */
/** @var \Framework\Auth\AppUser $user */
/** @var \Framework\Support\LinkGenerator $link */
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <title><?= App\Configuration::APP_NAME ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicons -->

    <link rel="icon" type="image/svg+xml" href="<?= $link->asset('favicons/app-icon.svg') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $link->asset('favicons/app-icon-16.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $link->asset('favicons/app-icon-32.png') ?>">
    <link rel="icon" type="image/png" sizes="192x192" href="<?= $link->asset('favicons/app-icon-192.png') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= $link->asset('css/styl.css') ?>">
    <script src="<?= $link->asset('js/authChecks.js') ?>"></script>
    <script src="<?= $link->asset('js/script.js') ?>"></script>
    <script src="<?= $link->asset('js/quizChecks.js') ?>"></script>
</head>
<body>

<!-- small sentinel before navbar observed by IntersectionObserver; 1px tall and does not affect layout -->
<div id="navSentinel"></div>

<!-- keep nav sticky but make background/shadow part of outer nav so it covers full width and is opaque -->
<nav class="navbar navbar-expand-sm sticky-top bg-light shadow-sm" id="mainNavbar">
    <div class="container">

        <!-- Brand: square book icon + site name (clickable to home) -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?= $link->url('home.index') ?>">
            <span class="logo-square d-inline-flex align-items-center justify-content-center">
                <!-- simple book SVG icon (keeps visual small and sharp) -->
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                    <path d="M1 2.828c.885-.37 2.154-.828 4-.828 1.243 0 2.09.33 2.5.5V13.5c-.41-.17-1.257-.5-2.5-.5-1.846 0-3.115.458-4 .828V2.828z"/>
                    <path d="M9 2.5V13.5c.41-.17 1.257-.5 2.5-.5 1.846 0 3.115.458 4 .828V2.5a1 1 0 0 0-1-1c-1.893 0-3.392.4-4.5.9C10.272 2.001 9.57 2.5 9 2.5z"/>
                </svg>
            </span>
            <span class="brand-text fw-bold">Kvizátor</span>
        </a>

        <!-- Toggler for small viewports: toggles the user/login menu -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarUserMenu" aria-controls="navbarUserMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarUserMenu">
            <?php if ($user->isLoggedIn()) { ?>
                <!-- Small-screen vertical menu (visible only below sm) -->
                <ul class="navbar-nav d-sm-none w-100">
                    <li class="nav-item"><a class="nav-link" href="<?= $link->url('account.settings') ?>">Settings</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= $link->url('quiz.edit') ?>">Create Quiz</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= $link->url('quiz.own') ?>">Edit Quiz</a></li>
                    <li class="nav-item"><hr class="dropdown-divider"></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="<?= $link->url('auth.logout') ?>">Log out</a></li>
                </ul>

                <!-- Desktop dropdown (visible at sm and above) -->
                <ul class="navbar-nav ms-auto d-none d-sm-flex">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userMenuDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= htmlspecialchars($user->getName(), ENT_QUOTES, 'UTF-8') ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuDropdown">
                            <li><a class="dropdown-item" href="<?= $link->url('account.settings') ?>">Settings</a></li>
                            <li><a class="dropdown-item" href="<?= $link->url('quiz.edit') ?>">Create Quiz</a></li>
                            <li><a class="dropdown-item" href="<?= $link->url('quiz.own') ?>">Edit Quiz</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?= $link->url('auth.logout') ?>">Log out</a></li>
                        </ul>
                    </li>
                </ul>
            <?php } else { ?>
                <!-- Small-screen vertical login/register (visible only below sm) -->
                <ul class="navbar-nav d-sm-none w-100">
                    <li class="nav-item"><a class="nav-link" href="<?= App\Configuration::LOGIN_URL ?>">Log in</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= $link->url("auth.register") ?>">Register</a></li>
                </ul>

                <!-- Desktop login/register links (visible at sm and above) -->
                <ul class="navbar-nav ms-auto d-none d-sm-flex d-flex flex-row gap-2 flex-nowrap align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= App\Configuration::LOGIN_URL ?>">Log in</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $link->url("auth.register") ?>">Register</a>
                    </li>
                </ul>
            <?php } ?>
        </div>
    </div>
</nav>

<!-- Spacer element used to prevent layout shift when navbar becomes sticky -->
<div id="navSpacer"></div>

<div class="container">
    <div class="web-content">
        <?= $contentHTML ?>
    </div>
</div>

</body>
</html>
