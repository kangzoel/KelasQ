require('./bootstrap')

$('.select2').select2()

/* When the user scrolls down, hide the navbar. When the user scrolls up, show the navbar */
let prevScrollpos = window.pageYOffset

window.onscroll = function () {
    const currentScrollPos = window.pageYOffset

    if (prevScrollpos > currentScrollPos) {
        document.getElementsByTagName('header')[0].style.top = "0"
    } else {
        document.getElementsByTagName('header')[0].style.top = "-58px"
    }
    prevScrollpos = currentScrollPos
}
