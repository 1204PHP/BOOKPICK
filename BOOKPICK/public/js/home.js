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
function setupSliderEvents(slider) {
	let isMouseDown = false;
	let startX, scrollLeft;

	slider.addEventListener('mousedown', (e) => {
		isMouseDown = true;
		slider.classList.add('active');
		startX = e.pageX - slider.offsetLeft;
		scrollLeft = slider.scrollLeft;
	});

	slider.addEventListener('mouseleave', handleMouseUp);
	slider.addEventListener('mouseup', handleMouseUp);

	slider.addEventListener('mousemove', (e) => {
		if (!isMouseDown) return;
		e.preventDefault();
		const x = e.pageX - slider.offsetLeft;
		const walk = (x - startX) * 1.5;
		requestAnimationFrame(() => {
		slider.scrollLeft = scrollLeft - walk;
		});
	});

	function handleMouseUp() {
		isMouseDown = false;
		slider.classList.remove('active');
	}
}

const slider = document.getElementById('slide');
const slider1 = document.getElementById('slide1');
const slider2 = document.getElementById('slide2');
const slider3 = document.getElementById('slide3');
const slider4 = document.getElementById('slide4');
const slider5 = document.getElementById('slide5');

setupSliderEvents(slider);
setupSliderEvents(slider1);
setupSliderEvents(slider2);
setupSliderEvents(slider3);
setupSliderEvents(slider4);
setupSliderEvents(slider5);





