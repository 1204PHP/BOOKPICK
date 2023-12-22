// 메인 광고 캐러셀
let currentSlideIndex = 1;

function showSlide(index) {
	const slides = document.querySelector('.home-baaner');
	const indicators = document.querySelectorAll('.indicator');

	// 해당 요소가 존재하는지 확인
    if (!slides) {
        return;
    }

	if (index > slides.childElementCount) {
		currentSlideIndex = 1;
	} else if (index < 1) {
		currentSlideIndex = slides.childElementCount;
	} else {
		currentSlideIndex = index;
	}

	slides.style.transform = `translateX(${-100 * (currentSlideIndex - 1)}%)`;

	indicators.forEach(indicator => indicator.classList.remove('active'));
	indicators[currentSlideIndex - 1].classList.add('active');
}

function currentSlide(index) {
	showSlide(index);
}

function nextSlide() {
	showSlide(currentSlideIndex + 1);
}

setInterval(nextSlide, 3000); // 슬라이드 자동 전환

// 베스트셀러 슬라이드
function next() {
	const slideContainer = document.querySelector('.slide-container');

    // 해당 요소가 존재하는지 확인
    if (!slideContainer) {
        return;
    }

	let baseWidth = document.querySelector('.slide-container').offsetWidth;
	let nowLeft = document.querySelector('.slide-container').scrollLeft;
	slideContainer.scrollTo({left: nowLeft + baseWidth, behavior: 'smooth'});
}
function prev() {
	const slideContainer = document.querySelector('.slide-container');

    // 해당 요소가 존재하는지 확인
    if (!slideContainer) {
        return;
    }

    let baseWidth = document.querySelector('.slide-container').offsetWidth;
    let nowLeft = document.querySelector('.slide-container').scrollLeft;
    slideContainer.scrollTo({ left: nowLeft - baseWidth, behavior: 'smooth' });
}


// 슬라이더 마우스로 드래드 하기
const slider = document.getElementById('slide');
let isMouseDown = false;
let startX, scrollLeft;

slider.addEventListener('mousedown', (e) => {
	isMouseDown = true;
	slider.classList.add('active');

	startX = e.pageX - slider.offsetLeft;
	scrollLeft = slider.scrollLeft;
});

slider.addEventListener('mouseleave', () => {
	isMouseDown = false;
	slider.classList.remove('active');
});

slider.addEventListener('mouseup', () => {
	isMouseDown = false;
	slider.classList.remove('active');
});

slider.addEventListener('mousemove', (e) => {
	if (!isMouseDown) return;
		e.preventDefault();
		const x = e.pageX - slider.offsetLeft;
		const walk = (x - startX) * 1.5;
		requestAnimationFrame(() => {
			slider.scrollLeft = scrollLeft - walk;
		});
		
});



//  카드 슬라이더
// const slider2 = document.getElementById('slider2');
// const cards = document.getElementById('card');

// // 카드 슬라이더 애니메이션 초기화
// gsap.to(cards, { x: i => i * 310, duration: 0.5, ease: 'power2.out' });

// // 카드 슬라이더 드래그 앤 드롭 기능 추가
// Draggable.create(slider2, {
//   type: 'x',
//   edgeResistance: 0.5,
//   bounds: '#slider',
//   snap: 'x',
//   snapSpacing: 310,
// });


const slider2 = document.getElementById('slide2');
let isMouseDown2 = false;
let startX2, scrollLeft2;

slider2.addEventListener('mousedown', (e) => {
	isMouseDown2 = true;
	slider2.classList.add('active');

	startX2 = e.pageX - slider2.offsetLeft;
	scrollLeft2 = slider2.scrollLeft;
	// console.log('mousedown', startX2, scrollLeft2, slider2.offsetLeft);
});

slider2.addEventListener('mouseleave', () => {
	isMouseDown2 = false;
	slider2.classList.remove('active');
	// console.log('mouseleave');
});

slider2.addEventListener('mouseup', () => {
	isMouseDown2 = false;
	slider2.classList.remove('active');
	// console.log('mouseup');
});

slider2.addEventListener('mousemove', (e) => {
	if (!isMouseDown2) return;

	e.preventDefault();
	const x2 = e.pageX - slider2.offsetLeft;
	const walk2 = (x2 - startX2) * 1.5;
	// console.log('mousemove', x2, walk2, slider2.offsetLeft);
	requestAnimationFrame(() => {
			slider2.scrollLeft = scrollLeft2 - walk2;
	});
});

const slider3 = document.getElementById('slide3');
let isMouseDown3 = false;
let startX3, scrollLeft3;

slider3.addEventListener('mousedown', (e) => {
	isMouseDown3 = true;
	slider3.classList.add('active');

	startX3 = e.pageX - slider3.offsetLeft;
	scrollLeft3 = slider3.scrollLeft;
	// console.log('mousedown', startX2, scrollLeft2, slider2.offsetLeft);
});

slider3.addEventListener('mouseleave', () => {
	isMouseDown3 = false;
	slider3.classList.remove('active');
	// console.log('mouseleave');
});

slider3.addEventListener('mouseup', () => {
	isMouseDown3 = false;
	slider3.classList.remove('active');
	// console.log('mouseup');
});

slider3.addEventListener('mousemove', (e) => {
	if (!isMouseDown3) return;

	e.preventDefault();
	const x3 = e.pageX - slider3.offsetLeft;
	const walk3 = (x3 - startX3) * 1.5;
	// console.log('mousemove', x2, walk2, slider2.offsetLeft);
	requestAnimationFrame(() => {
			slider3.scrollLeft = scrollLeft3 - walk3;
	});
});


// ***************둘러보기 페이지 자바스크립트 *********************

