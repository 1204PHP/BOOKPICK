function BookDetailshowAlert() {
	var wishList = document.getElementById('wishFlg').value;
	
	console.log(wishList);
	if (wishList === '2') {
		alert("로그인이 필요합니다.");
	} else if (wishList === '0') {
		// 0(찜된상태)일경우 alert띄우고 wishlist가 1(찜안된상태)로 변경
		alert("찜 삭제가 되었습니다.");
	} else if (wishList === '1') {
		alert("찜 등록이 되었습니다.");
	}
}