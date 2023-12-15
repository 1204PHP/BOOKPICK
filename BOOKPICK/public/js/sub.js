// 주간 베스트 버튼, 캐러셀 영역

    const track = document.querySelector('.best-gird-box1');
    const items = document.querySelectorAll('.imgsize');
    const itemsPerGroup = 2; // 한 번에 넘어갈 아이템의 수
    const groupWidth = 100 / itemsPerGroup; // 각 그룹의 너비 (백분율)
    const nextbtn = document.querySelector('.carousel-next');
    const prevbtn = document.querySelector('.carousel-prev');
    let currentIndex = 0;


	function updateCarousel() {
		const translateXValue = currentIndex * groupWidth;
		track.style.transform = `translateX(${-translateXValue}%)`;
        const lastGroupIndex = Math.ceil(items.length / itemsPerGroup) - 1;
        const isLastGroup = currentIndex >= lastGroupIndex * itemsPerGroup;

    // isLastGroup을 통해 마지막 그룹이라면 다음 버튼을 숨깁니다.
        nextbtn.style.display = isLastGroup ? 'none' : 'block';
	}

    function nextSlide() {
        const lastGroupStartIndex = (Math.ceil(items.length / itemsPerGroup) - 1) * itemsPerGroup;
        if (currentIndex < lastGroupStartIndex) {
            currentIndex += itemsPerGroup;
            updateCarousel();
        }
			const lastGroupIndex = Math.ceil(items.length / itemsPerGroup);
			nextbtn.style.display = currentIndex < lastGroupIndex * itemsPerGroup ? 'block' : 'none';
    }

    function prevSlide() {
        currentIndex = Math.max(currentIndex - itemsPerGroup, 0);
        updateCarousel();
		nextbtn.style.display = 'block';
    }

    
    nextbtn.addEventListener('click', nextSlide);
    prevbtn.addEventListener('click', prevSlide);

// 월간 베스트 버튼, 캐러셀 영역 (버튼 클레스 달라서 따로 만듬)
document.addEventListener('DOMContentLoaded', function () {
    const track = document.querySelector('.best-gird-box2');
    const items = document.querySelectorAll('.img-best2');
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
			document.querySelector('.carousel-next-m').style.display = currentIndex > lastGroupIndex ? 'block' : 'none';
    }

    function prevSlide() {
        currentIndex = Math.max(currentIndex - itemsPerGroup, 0);
        updateCarousel();
		document.querySelector('.carousel-next-m').style.display = 'block';
    }

    document.querySelector('.carousel-next-m').addEventListener('click', nextSlide);
    document.querySelector('.carousel-prev-m').addEventListener('click', prevSlide);
});