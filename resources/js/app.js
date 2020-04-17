require('./bootstrap');

/* When the user scrolls down, hide the navbar. When the user scrolls up, show the navbar */
var prevScrollpos = window.pageYOffset;
window.onscroll = function () {
    var currentScrollPos = window.pageYOffset;
    if (prevScrollpos > currentScrollPos) {
        document.getElementsByTagName('header')[0].style.top = "0";
    } else {
        document.getElementsByTagName('header')[0].style.top = "-58px";
    }
    prevScrollpos = currentScrollPos;
}
