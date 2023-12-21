function BookDetailWishFlgshowAlert() {
	var wishFlg = document.getElementById('wishFlg').value;
	
	console.log(wishFlg);
	if (wishFlg === '2') {
		alert("로그인이 필요합니다.");
	} else if (wishFlg === '0') {
		// 0(찜된상태)일경우 alert띄우고 wishlist가 1(찜안된상태)로 변경
		alert("찜 삭제가 되었습니다.");
	} else if (wishFlg === '1') {
		alert("찜 등록이 되었습니다.");
	}
}

function BookDetailLibraryFlgshowAlert() {
	var libraryFlg = document.getElementById('libraryFlg').value;
	
	console.log(libraryFlg);
	if (libraryFlg === '2') {
		alert("로그인이 필요합니다.");
	} else if (libraryFlg === '0') {
		alert("나의서재에서 삭제 되었습니다.");
	} else if (libraryFlg === '1') {
		alert("나의서재에 등록이 되었습니다.");
	}
}


// document.getElementById('detailEndDate').addEventListener('click', function() {
// 	showDatePicker();
// });
// function showDatePicker() {
// 	// 현재 날짜를 가져오기
// 	var currentDate = new Date();

// 	// 사용자에게 날짜를 선택하도록 요청
// 	var selectedDate = prompt('날짜를 선택하세요 (YYYY-MM-DD)', currentDate.toISOString().split('T')[0]);

// 	// 선택한 날짜를 input 요소에 설정
// 	if (selectedDate) {
// 		document.getElementById('detailEndDate').value = selectedDate;
// 	}
// }