// 햄버거버튼 
function hamburgerMenuOpenClose() {
    const hamburgerMenu = document.querySelector(".hamburger-menu");
    const mobileNav = document.querySelector(".mobile-nav");

    if (hamburgerMenu && mobileNav) {
        mobileNav.style.display = (mobileNav.style.display === "flex") ? "none" : "flex";
        hamburgerMenu.classList.toggle("open");
    }
}

window.addEventListener("resize", function () {
    const hamburgerMenu = document.querySelector(".hamburger-menu");
    const mobileNav = document.querySelector(".mobile-nav");

    if (window.innerWidth > 768 && hamburgerMenu && mobileNav) {
        mobileNav.style.display = "none";
        hamburgerMenu.classList.remove("open");
    }
});

// 유저 아이콘
document.addEventListener("DOMContentLoaded", function() {
    const userIcon = document.querySelector(".user-icon");
    const userMenu = document.querySelector(".user-menu");

    if (userMenu && userIcon) {
        userIcon.addEventListener("click", function () {
            userMenu.style.display = (userMenu.style.display === "flex") ? "none" : "flex";
            userIcon.classList.toggle("open");
        });
    
        window.addEventListener("resize", function () {
            if (window.innerWidth > 768) {
                userMenu.style.display = "none";
                userIcon.classList.remove("open");
            }
        });
    } 
});

// tour 광고 캐러셀

var slideIndex = 1;
var slideInterval;

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
    n = 1;
    showSlides(slideIndex += n);
}

// setInterval(slideTime, 6000);

function startInterval() {
    slideInterval = setInterval(slideTime, 6000);
}

function stopInterval() {
    clearInterval(slideInterval);
}

// 마우스가 캐러셀 영역에 들어왔을 때
document.querySelector('.slide-container-1').addEventListener('mouseenter', stopInterval);

// 마우스가 캐러셀 영역에서 나갔을 때
document.querySelector('.slide-container-1').addEventListener('mouseleave', startInterval);

// 초기에 인터벌 시작
startInterval();
