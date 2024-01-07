// 호철 수정중
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

// tour 광고 캐러셀

var slideIndex = 1;
showSlides(slideIndex);

function plusSlide(n) {
    showSlides((slideIndex += n));
}

function currentSlide(n) {
    showSlides((slideIndex = n));
}

function showSlides (n){
    var i;
    var slides = document.getElementsByClassName("slide-content");
    var balls = document.getElementsByClassName("ball");

    if (n > slides.length) {
        slideIndex = 1
    }
    if (n < 1) {
        slideIndex = slides.length
    }
    for (i = 0; i < slides.length; i++){
        slides[i].style.display = "none";
    }
    for (i = 0; i < balls.length; i++){
        balls[i].className = balls[i].className.replace("active","");
    }
	slides[slideIndex-1].style.display = "block";
	balls[slideIndex-1].className+= " active";
}



function slideTime(n){
    n=1
    showSlides(slideIndex += n);
}

setInterval(slideTime, 5000);


