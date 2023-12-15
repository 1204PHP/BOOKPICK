// 주간 베스트 버튼, 캐러셀 영역
const track = document.querySelector('.best-gird-box1');
const items = document.querySelectorAll('.imgsize');
const nextbtn = document.querySelector('.carousel-next');
const prevbtn = document.querySelector('.carousel-prev');
let currentIndex = 0;

function updateCarousel() {
    const translateXValue = -currentIndex * 100 + '%';
    track.style.transform = 'translateX(' + translateXValue + ')';
    updateButtonsVisibility();
}

function nextSlide() {
    if (currentIndex < items.length - 1) {
        currentIndex++;
        updateCarousel();
    }
}

function prevSlide() {
    if (currentIndex > 0) {
        currentIndex--;
        updateCarousel();
    }
}

function updateButtonsVisibility() {
    // 다음 버튼 표시 여부 업데이트
    nextbtn.style.display = currentIndex < items.length - 1 ? 'block' : 'none';

    // 이전 버튼 표시 여부 업데이트
    prevbtn.style.display = currentIndex > 0 ? 'block' : 'none';
}

nextbtn.addEventListener('click', nextSlide);
prevbtn.addEventListener('click', prevSlide);

// 쌤이 준거

function my_next() {
    console.log('next() 실행');
    let baseWidth = document.querySelector('.best-gird-box2').offsetWidth;
    let nowLeft = document.querySelector('.best-gird-box2').scrollLeft;
    let nextbtn = document.querySelector('.carousel-next-m');
    document.querySelector('.best-gird-box2').scrollTo({left: nowLeft + 200, behavior: 'smooth'});
    nextbtn.style.display = currentIndex < items.length - 1 ? 'block' : 'none';
}