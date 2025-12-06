<?php

/** @var string $contentHTML */
/** @var \Framework\Auth\AppUser $user */
/** @var \Framework\Support\LinkGenerator $link */
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <title><?= App\Configuration::APP_NAME ?></title>
    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $link->asset('favicons/apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $link->asset('favicons/favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $link->asset('favicons/favicon-16x16.png') ?>">
    <link rel="manifest" href="<?= $link->asset('favicons/site.webmanifest') ?>">
    <link rel="shortcut icon" href="<?= $link->asset('favicons/favicon.ico') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= $link->asset('css/styl.css') ?>">
    <script src="<?= $link->asset('js/script.js') ?>"></script>
</head>
<body>

<!-- small sentinel before navbar observed by IntersectionObserver; 1px tall and does not affect layout -->
<div id="navSentinel" style="height:1px; width:100%;"></div>

<!-- keep nav sticky but make background/shadow part of outer nav so it covers full width and is opaque -->
<nav class="navbar navbar-expand-sm sticky-top bg-light shadow-sm" style="z-index:1020;" id="mainNavbar">
    <div class="container">

        <ul class="navbar-nav ms-left">
            <li class="nav-item">
                <a class="nav-link" href="<?= $link->url('home.index') ?>">Home</a>
            </li>
        </ul>
        <?php if ($user->isLoggedIn()) { ?>
            <ul class="navbar-nav ms-auto">
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
            <ul class="navbar-nav ms-auto d-flex flex-row gap-2 flex-nowrap align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="<?= App\Configuration::LOGIN_URL ?>">Log in</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $link->url("auth.register") ?>">Register</a>
                </li>
            </ul>
        <?php } ?>
    </div>
</nav>

<!-- Spacer element used to prevent layout shift when navbar becomes sticky -->
<div id="navSpacer" style="height:0; transition: height 160ms ease;"></div>

<div class="container">
    <div class="web-content">
        <?= $contentHTML ?>
    </div>
</div>

<script>
    // Observe the small sentinel above the navbar; when it leaves the viewport we toggle
    // a class on <html> and set --nav-height so CSS can animate the spacer smoothly.
    (function () {
        var nav = document.getElementById('mainNavbar');
        var spacer = document.getElementById('navSpacer');
        var sentinel = document.getElementById('navSentinel');
        var docEl = document.documentElement;
        if (!nav || !spacer || !sentinel || !docEl) return;

        function activate() {
            var h = nav.offsetHeight + 'px';
            // set CSS variable and add class, allow CSS to animate spacer
            docEl.style.setProperty('--nav-height', h);
            if (!docEl.classList.contains('nav-sticky')) docEl.classList.add('nav-sticky');
        }
        function deactivate() {
            // remove class; spacer will animate to 0
            if (docEl.classList.contains('nav-sticky')) docEl.classList.remove('nav-sticky');
            // optionally clear var (keeps last value though)
            // docEl.style.removeProperty('--nav-height');
        }

        function updateOnResize() {
            if (docEl.classList.contains('nav-sticky')) {
                // refresh variable to the new height
                docEl.style.setProperty('--nav-height', nav.offsetHeight + 'px');
            }
        }

        if ('IntersectionObserver' in window) {
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    // when sentinel is out of view -> navbar has reached top -> activate spacer
                    if (entry.isIntersecting) {
                        // sentinel visible -> navbar in normal flow
                        deactivate();
                    } else {
                        // sentinel out of view -> navbar sticky
                        activate();
                    }
                });
            }, { root: null, threshold: 0 });

            io.observe(sentinel);

            // keep value updated on resize
            window.addEventListener('resize', updateOnResize);

            // ensure correct initial state on load
            window.addEventListener('load', function () {
                if (sentinel.getBoundingClientRect().top < 0) activate(); else deactivate();
            });
        } else {
            // Fallback for old browsers: use scroll and resize
            function check() {
                if (sentinel.getBoundingClientRect().top < 0) activate(); else deactivate();
            }
            window.addEventListener('scroll', check, {passive: true});
            window.addEventListener('resize', function () { check(); updateOnResize(); });
            window.addEventListener('load', check);
            document.addEventListener('DOMContentLoaded', check);
            check();
        }
    })();
</script>
</body>
</html>
