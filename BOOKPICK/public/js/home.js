// let currentSlideIndex = 1;

//     function showSlide(index) {
//         const slides = document.querySelector('.home-baaner');
//         const indicators = document.querySelectorAll('.indicator');

//         if (index > slides.childElementCount) {
//             currentSlideIndex = 1;
//         } else if (index < 1) {
//             currentSlideIndex = slides.childElementCount;
//         } else {
//             currentSlideIndex = index;
//         }

//         slides.style.transform = `translateX(${-100 * (currentSlideIndex - 1)}%)`;

//         indicators.forEach(indicator => indicator.classList.remove('active'));
//         indicators[currentSlideIndex - 1].classList.add('active');
//     }

//     function currentSlide(index) {
//         showSlide(index);
//     }

//     function nextSlide() {
//         showSlide(currentSlideIndex + 1);
//     }

//     function prevSlide() {
//         showSlide(currentSlideIndex - 1);
//     }

//     setInterval(nextSlide, 3000);


let currentSlideIndex = 1;

function showSlide(index) {
	const slides = document.querySelector('.home-baaner');
	const indicators = document.querySelectorAll('.indicator');
	const textBoxes = document.querySelectorAll('.home-box');

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

	textBoxes.forEach(textBox => textBox.classList.remove('active'));
	textBoxes[currentSlideIndex - 1].classList.add('active');
}

function currentSlide(index) {
	showSlide(index);
}

function nextSlide() {
	showSlide(currentSlideIndex + 1);
}

setInterval(nextSlide, 3000); // 슬라이드 자동 전환