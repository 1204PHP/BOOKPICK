// 햄버거 버튼
const hamburgerMenu = document.querySelector(".hamburger-menu");
const mobileNav = document.querySelector(".mobile-nav");

hamburgerMenu.addEventListener("click", function () {
    mobileNav.style.display = (mobileNav.style.display === "flex") ? "none" : "flex";
    hamburgerMenu.classList.toggle("open");
});

window.addEventListener("resize", function () {
    if (window.innerWidth > 768) {
        mobileNav.style.display = "none";
        hamburgerMenu.classList.remove("open");
    }
});

// 유저 아이콘
const userIcon = document.querySelector(".user-icon");
const userMenu = document.querySelector(".user-menu");

userIcon.addEventListener("click", function() {
    userMenu.style.display = (userMenu.style.display === "flex") ? "none" : "flex";
    userIcon.classList.toggle("open");
});

window.addEventListener("resize", function () {
    if (this.window.innerWidth > 768) {
        userMenu.style.display = "none";
        userIcon.classList.remove("open")
    }
});

// tour 광고 캐러셀

var slideIndex = 1;
showSlides(slideIndex);

function plusSlide(n) {
    showSlides((slideIndex += n));
}

function currentSlide(n) {
    showSlides((slideIndex = n));
}

function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("slide-content");
    var balls = document.getElementsByClassName("ball");

    if (slides.length > 0 && balls.length > 0) {
        if (n > slides.length) {
            slideIndex = 1;
        }
        if (n < 1) {
            slideIndex = slides.length;
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < balls.length; i++) {
            balls[i].className = balls[i].className.replace("active", "");
        }
        slides[slideIndex - 1].style.display = "block";
        balls[slideIndex - 1].className += " active";
    }
}


function slideTime(n){
    n=1
    showSlides(slideIndex += n);
}

setInterval(slideTime, 5000);


