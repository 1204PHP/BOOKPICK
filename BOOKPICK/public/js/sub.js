document.addEventListener('DOMContentLoaded', function () {
    const track = document.querySelector('.best-gird-box1');
    const items = document.querySelectorAll('.img-best1');
    const itemsPerGroup = 2; // 한 번에 넘어갈 아이템의 수
    const groupWidth = 100 / itemsPerGroup; // 각 그룹의 너비 (백분율)

    let currentIndex = 0;


	function updateCarousel() {
		const translateXValue = currentIndex * groupWidth;
		track.style.transform = `translateX(${-translateXValue}%)`;
	}

    function nextSlide() {
        const lastGroupStartIndex = (Math.ceil(items.length / itemsPerGroup) - 1) * itemsPerGroup;
        if (currentIndex < lastGroupStartIndex) {
            currentIndex += itemsPerGroup;
            updateCarousel();
        }
			const lastGroupIndex = Math.ceil(items.length / itemsPerGroup);
			document.querySelector('.carousel-next').style.display = currentIndex > lastGroupIndex ? 'block' : 'none';
			// 여기에서 마지막 그룹에 도달했을 때의 동작을 수행합니다.
			// 예: 버튼을 숨기는 등의 동작을 수행할 수 있습니다.
    }

    function prevSlide() {
        currentIndex = Math.max(currentIndex - itemsPerGroup, 0);
        updateCarousel();
		document.querySelector('.carousel-next').style.display = 'block';
    }

    document.querySelector('.carousel-next').addEventListener('click', nextSlide);
    document.querySelector('.carousel-prev').addEventListener('click', prevSlide);
});