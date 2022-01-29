const closeBtn = document.getElementById("nav-close");
const navMenu = document.getElementById("nav-menu");
const navToggle = document.getElementById("nav-toggle");
const themeButton = document.getElementById("theme-button");

// menu
navToggle.addEventListener("click", function () {
    navMenu.classList.toggle("show");
});

closeBtn.addEventListener("click", function () {
    navMenu.classList.toggle("show");
});

// theme
themeButton.addEventListener("click", function () {
    document.body.classList.toggle("dark-theme");
    if (themeButton.classList.contains("bx-moon")) {
        themeButton.classList.remove("bx-moon");
        themeButton.classList.add("bx-sun");
    } else {
        themeButton.classList.remove("bx-sun");
        themeButton.classList.add("bx-moon");
    }
});

// headers
function scrollHeader() {
    const header = document.getElementById("header");
    // When the scroll is greater than 50 viewport height, add the scroll-header class to the header tag
    if (this.scrollY >= 50) header.classList.add("scroll-header");
    else header.classList.remove("scroll-header");
}
window.addEventListener("scroll", scrollHeader);

window.addEventListener("scroll", function () {
    const scrollUp = document.getElementById("scroll-up");

    this.scrollY >= 400
        ? scrollUp.classList.add("show-scroll")
        : scrollUp.classList.remove("show-scroll");
});

// swipper

let testimonialSwiper = new Swiper(".testimonial-swipper", {
    spaceBetween: 30,
    loop: true,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});

let newSwiper = new Swiper(".new-swipper", {
    spaceBetween: 20,
    loop: true,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        640: {
            slidesPerView: 2,
        },
        768: {
            slidesPerView: 3,
        },
        1024: {
            slidesPerView: 4,
        },
    },
});

const navUser = document.getElementById("nav-user");
const dropdownClose = document.getElementById("dropdown-close");
const dropdown = document.getElementById("dropdown");

navUser.addEventListener("click", function () {
    dropdown.classList.toggle("show");
});

dropdownClose.addEventListener("click", function () {
    dropdown.classList.remove("show");
});

// fullscreen
const fullscreen = document.getElementById("fullscreen");
const left = document.getElementById("watch-data-left");
const right = document.getElementById("watch-data-right");

fullscreen.addEventListener("click", function () {
    left.classList.toggle("show");
    right.classList.toggle("show");
});

dropdownClose.addEventListener("click", function () {
    dropdown.classList.toggle("show");
});

const closeAlert = document.getElementById("close-alert");
const alert = document.getElementById("alert");

closeAlert.addEventListener("click", function () {
    alert.classList.add("remove");
});
