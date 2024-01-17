

// 서재상세 페이지
function LibraryDetailopenModal() {
	var myModal = document.getElementById('myModal');
	myModal.classList.toggle('modal');
}

function LibraryDetailFlgshowAlert(event) {
	var libraryFlg = document.getElementById('libraryFlg').value;

	console.log(libraryFlg);
	if (libraryFlg === '0') {
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
			alert("날짜가 수정되었습니다.");
		}
	} else {
		event.preventDefault();
		window.location.href = "/library/wishlist";
	}
}

function confirmDelete() {
	var isConfirmed = confirm("나의 서재에서 해당 도서를 삭제하시겠습니까?");

	if (isConfirmed) {
		alert("나의 서재에서 해당 도서가 삭제되었습니다.");
		return true;
	} else {
		// 사용자가 취소("아니요")를 선택한 경우
		// 폼 제출을 중단합니다.
		return false;
	}
}

function commentConfirmDelete() {
	var isConfirmed = confirm("댓글을 삭제하시겠습니까?");

	if (isConfirmed) {
		alert("댓글이 삭제되었습니다.");
		return true;
	} else {
		// 사용자가 취소("아니요")를 선택한 경우
		// 폼 제출을 중단합니다.
		return false;
	}
}



	// 댓글 삽입 모달
	const modalOpenBtn = document.querySelector("#book_detail_comment_modal_btn").addEventListener("click", (e) => {
	const modal = document.querySelector('.book_detail_comment_modal');
		modal.classList.toggle('show');
	});
	
	const closeModalBtn = document.querySelector('.book_detail_comment_close_modal_btn');
	closeModalBtn.addEventListener('click', (e) => {
		const modal = document.querySelector('.book_detail_comment_modal');
	
		modal.classList.toggle('show');
	});



	// 댓글 수정 모달
	var ulcIdCntValue = document.getElementById('ulc_id_cnt').value;
	var ulcIdCntIntValue = parseInt(ulcIdCntValue, 10); 

	function toggleModal(elementId) {
		var detailModal = document.getElementById(elementId);
		detailModal.classList.toggle('show');
	}


	// 사용 예시
	for (var i = 0; i < ulcIdCntIntValue; i++) {
		// 클로저를 사용하여 각 이벤트 핸들러에 대한 독립적인 스코프 생성
		(function(index) {
			var getElementById3 = 'library_detail_comment_update_modal' + index;
			var dropdownContent = 'dropdown-content' + index;

			// 함수 호출을 통해 모달 토글
			document.getElementById('library_detail_comment_update_modal_btn' + index).addEventListener('click', function() {
				toggleModal(getElementById3);
				toggleModal(dropdownContent);
			});
	
			document.getElementById('library_detail_comment_update_close_modal_btn' + index).addEventListener('click', function() {
				toggleModal(getElementById3);
			});
			// 드롭다운 모달 토글
			document.getElementById('dropbtn' + index).addEventListener('click', function() {
				toggleModal(dropdownContent);
			});

			document.addEventListener('click', function(event) {
				var detailModal = document.getElementById('dropbtn' + index);
				var detaiDropDown = document.getElementById('dropdown-content' + index);
				var isClickInsideModal = detailModal.contains(event.target);
				var isModalActive = detaiDropDown.classList.contains('show');
				if (isModalActive && !isClickInsideModal) {
					detaiDropDown.classList.remove('show');
				}
			});
			
			document.getElementById('library_detail_comment_delete_modal_btn' + index).addEventListener('click', function() {
				toggleModal(dropdownContent);
			});
		})(i);
	}