// 슬라이더 마우스로 드래드 하기
document.addEventListener('click', function () {
	const slider = document.getElementById('slide');
	let isMouseDown = false;
	let startX, scrollLeft;

	if (slider) {
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
	}
});


// 슬라이더 두번째꺼

document.addEventListener('click', function () {	
	const slider2 = document.getElementById('slide2');
	let isMouseDown2 = false;
	let startX2, scrollLeft2;

	if(slider2) {
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
	}
});


// 메인 모달 관련

// 현재 열려있는 모달을 저장하는 변수
var openModal = null;

// 모달 열기
function openTourModal(modalId) {
	var modal = document.getElementById(modalId);
    // 현재 열려있는 모달이 없다면 모달을 열고 openModal 변수에 저장
    if (!openModal) {
        modal.style.display = 'block';
        openModal = modal;
    }
}

// 모달 닫기
function closeTourModal() {
    if (openModal) {
        openModal.style.display = 'none';
        openModal = null;
    }
}

// tour-card 클릭 시 모달 열기
function addTourCardClickListener(cardId, modalId) {
    var tourCard = document.getElementById(cardId);

    tourCard.addEventListener('click', function () {
        openTourModal(modalId);
    });
}

// 각각의 tour-card에 클릭 이벤트 추가
addTourCardClickListener('tour-card-1', 'tour-modal-1');
addTourCardClickListener('tour-card-2', 'tour-modal-2');
addTourCardClickListener('tour-card-3', 'tour-modal-3');

// 모달 닫기 버튼에 클릭 이벤트 추가
document.querySelectorAll('.tour-modal-close').forEach(function (closeButton) {
    closeButton.addEventListener('click', function () {
        closeTourModal();
    });
});
