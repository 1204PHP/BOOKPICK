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







//  호철 // 댓글 추가 모달 열기 닫기
const modalOpenBtn = document.querySelector("#book_detail_comment_modal_btn").addEventListener("click", (e) => {
	const modal = document.querySelector('.book_detail_comment_modal');
		modal.classList.toggle('show');
	});
	
	const closeModalBtn = document.querySelector('.book_detail_comment_close_modal_btn');
	closeModalBtn.addEventListener('click', (e) => {
		const modal = document.querySelector('.book_detail_comment_modal');
	
		modal.classList.toggle('show');
	});
	
	const modalBackground = document.querySelector('.book_detail_comment_modal');
	modalBackground.addEventListener('click', (e) => {
		const modal = document.querySelector('.book_detail_comment_modal');
	
		if (e.target === modal) {
		modal.classList.toggle('show');
		}
	});
