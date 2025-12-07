// nepouzivane
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
