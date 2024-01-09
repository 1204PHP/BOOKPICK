function BookDetailWishFlgshowAlert() {
	var wishFlg = document.getElementById('wishFlg').value;
	
	// if (wishFlg === '2') {
	// 	alert("로그인이 필요합니다.");
	// 	window.location.href = "/login";
	// } else 
	if (wishFlg === '0') {
		// 0(찜된상태)일경우 alert띄우고 wishlist가 1(찜안된상태)로 변경
		alert("찜 삭제가 되었습니다.");
	} else if (wishFlg === '1') {
		alert("찜 등록이 되었습니다.");
	}
}

function BookDetailLibraryFlgshowAlert(event) {
	var libraryFlg = document.getElementById('libraryFlg').value;

	// if (libraryFlg === '2') {
	// 	alert("로그인이 필요합니다.");
	// 	window.location.href = "/login";
	// }
	// else 
	if (libraryFlg === '0') {
		alert("나의 서재에서 삭제 되었습니다.");
	} else if (libraryFlg === '1') {
		var startDate = document.getElementById('detailStartDate').value;
		var endDate = document.getElementById('detailEndDate').value;
		var datePattern = /^\d{4}-\d{2}-\d{2}$/;

		if (!datePattern.test(startDate) || !datePattern.test(endDate)) {
			alert('올바른 날짜를 입력하세요.');
			event.preventDefault();
		} else if ((startDate > endDate)) {
			alert('시작 날짜는 끝나는 날짜보다 이전이어야 합니다.');
			event.preventDefault();
		} else {
			alert("나의 서재에 등록이 되었습니다.");
		}
	}
}

function BookDetailConfirm() {
	var userConfirmation = confirm("이 기능을 사용하려면 로그인이 필요합니다.\n지금 로그인 하시겠습니까?");
	if (userConfirmation) {
		window.location.href = "/login";
	} else {

	}
}

function BookDetailopenModal() {
	var myModal = document.getElementById('myModal');
	myModal.classList.toggle('modal');
}


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
const slider6 = document.getElementById('slide6');
setupSliderEvents(slider6);



