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






// *************상세 페이지 댓글 부분 자바스크립트 구현*************
// 댓글 삽입 placeholder + 글자 체크
function handleInput(textarea) {
    // 텍스트 영역의 값이 비어 있으면 레이블을 표시
    const label = document.querySelector('label[for="content"]');
    label.style.display = (textarea.value.trim() === '') ? 'block' : 'none';
}

function limitCharacters() {
    const commentInput = document.getElementById('content');
    const Count = document.getElementById('count');
    const maxCharacters = 700;

    var currentCharacters = commentInput.value.length;

    if (currentCharacters > maxCharacters) {
		alert("700자까지 입력할 수 있습니다.");
		currentCharacters == 701 ? currentCharacters = 700 : currentCharacters;
    	commentInput.value = commentInput.value.slice(0, maxCharacters);
    }
	Count.textContent = `${currentCharacters}` + " / " + maxCharacters;
}

// 대댓글 삽입 placeholder + 글자 체크
function replyHandleInput(textarea,bdc_id) {
    // 텍스트 영역의 값이 비어 있으면 레이블을 표시
	var labelName = 'label[for="replycontent'+bdc_id+'"]';
    const replylabel = document.querySelector(labelName);
    replylabel.style.display = (textarea.value.trim() === '') ? 'block' : 'none';
}

function replyLimitCharacters(bdc_id) {
	let replyContent='replycontent' + bdc_id;
	let replyCount='replycount' + bdc_id;
    const replyInputDOM = document.getElementById(replyContent);
    const replyCountDOM = document.getElementById(replyCount);
    const replyMaxCharacters = 700;

    var replyCurrentCharacters = replyInputDOM.value.length;

    if (replyCurrentCharacters > replyMaxCharacters) {
		alert("700자까지 입력할 수 있습니다.");
		replyCurrentCharacters == 701 ? replyCurrentCharacters = 700 : replyCurrentCharacters;
    	replyInputDOM.value = replyInputDOM.value.slice(0, maxCharacters);
    }
	replyCountDOM.textContent = `${replyCurrentCharacters}` + " / " + replyMaxCharacters;
}

function loginCheckConfirm() {
	if(confirm("로그인을 하신 후 이용해 주시기 바랍니다.")){
		window.location.href = "/login";
	} else {
	}
}



// 댓글 insert
function insertFormCheck() {
	let contentValue = document.getElementById("content").value;
	if (contentValue.trim() === "") {
			alert("내용을 입력해주세요.");
	} else {
			let formData = new FormData();
			let bId = document.getElementById("bdc_b_id").value;
			formData.append('b_id', bId);
			formData.append('content', contentValue);
			fetch('/book/detail/comment/insert', {
				method: 'POST',
				body: formData,
			})
			.then(response => response.json())
			.then(data => {
       			let errorMsg = data.errorMsg;
				if(errorMsg) {
					if(confirm("로그인을 하신 후 이용해 주시기 바랍니다.")){
						window.location.href = "/login";
					} else {
					}
				} else {
					categoryBtn(1);
					let commentResult = data.commentResult;
					let uNameResult = data.uNameResult;
					var parentElement = document.getElementById('bdc-list');

					var bdcHeadTxtCountDOM = document.getElementById('bdc-head-txt-count');
					var currentCount = parseInt(bdcHeadTxtCountDOM.innerHTML, 10);
					var newCount = currentCount + 1;

					bdcHeadTxtCountDOM.innerHTML = newCount;
					
					// 새로운 div 요소 생성
					var newDivElement = document.createElement('div');
					var StrNum = commentResult['bdc_id'];
					newDivElement.id = "bdc-list-area" + StrNum;
			
					// 리스트 상단 영역 생성
					var topArea = document.createElement('div');
					topArea.className = 'bdc-list-top-area';
			
					var imgElement = document.createElement('img');
					imgElement.className = 'bdc-list-area-img';
					imgElement.src = '/img/user.png';
					imgElement.alt = '';
			
					var nameElement = document.createElement('span');
					nameElement.className = 'bdc-list-area-name';
					nameElement.textContent = uNameResult['u_name'];
			
					var dateElement = document.createElement('span');
					dateElement.className = 'bdc-list-area-at';
					dateElement.textContent = new Date(commentResult['created_at'])
												.toLocaleString('ko-KR', 
													{year: 'numeric', month: '2-digit', day: '2-digit', hour: 'numeric', minute: 'numeric', hour12: false});
			
					topArea.appendChild(imgElement);
					topArea.appendChild(nameElement);
					topArea.appendChild(dateElement);
		
					// 리스트 중단 영역 생성
					var middleArea = document.createElement('div');
					middleArea.className = 'bdc-list-middle-area font-1';
			
					var contentElement = document.createElement('p');
					contentElement.className = 'bdc-list-area-content';
					contentElement.textContent = commentResult['bdc_comment'];
			
					middleArea.appendChild(contentElement);
			
					// 리스트 하단 영역 생성
					var bottomArea = document.createElement('div');
					bottomArea.className = 'bdc-list-bottom-area';
			
					var replyLink = document.createElement('a');
					replyLink.className = 'bdc-list-area-reply'
					replyLink.textContent = '답글';
					replyLink.onclick = function() {
						var StrNum = commentResult['bdc_id'];
						replyOpen(StrNum);
					};
		
					var replyCount = document.createElement('span');
					replyCount.className = 'bdc-list-area-reply-cnt';
					replyCount.textContent = '0';
					replyCount.id = 'bdc-list-area-reply-cnt' + StrNum;
			
					replyLink.appendChild(replyCount);
			
					var recommendArea = document.createElement('div');
					recommendArea.className = 'bdc-list-recommend-area';
			
					var StrNum = commentResult['bdc_id'];

					var likeBox = document.createElement('a');
					likeBox.className = 'bdc-list-area-like-box';
					likeBox.id = 'bdc-list-area-like-box' + StrNum;
					likeBox.onclick = function() {
						var StrNum = commentResult['bdc_id'];
						likeInsert(StrNum);
					};
					var likeImg = document.createElement('img');
					likeImg.className = 'bdc-dis-like-btn';
					likeImg.src = '/img/book_detail_like.png';
					likeImg.alt = '';
					
					var likeCount = document.createElement('span');
					likeCount.textContent = '0';
					likeCount.id= 'like-count' + StrNum;

					likeBox.appendChild(likeImg);
					likeBox.appendChild(likeCount);
					var dislikeBox = document.createElement('a');
					dislikeBox.className = 'bdc-list-area-dislike-box';
					dislikeBox.id = 'bdc-list-area-dislike-box' + StrNum;
					dislikeBox.onclick = function() {
						var StrNum = commentResult['bdc_id'];
						dislikeInsert(StrNum);
					};

					var dislikeImg = document.createElement('img');
					dislikeImg.className = 'bdc-dis-like-btn';
					dislikeImg.src = '/img/book_detail_dislike.png';
					dislikeImg.alt = '';
			
					var dislikeCount = document.createElement('span');
					dislikeCount.textContent = '0';
					dislikeCount.id= 'dislike-count' + StrNum;
			
					dislikeBox.appendChild(dislikeImg);
					dislikeBox.appendChild(dislikeCount);
			
					recommendArea.appendChild(likeBox);
					recommendArea.appendChild(dislikeBox);
			
					bottomArea.appendChild(replyLink);
					bottomArea.appendChild(recommendArea);
			
					var BinDiv = document.createElement('div');
					BinDiv.className = 'bdc-list-area';
		
					// 새로운 div 요소에 생성한 영역들 추가
					BinDiv.appendChild(topArea);
					BinDiv.appendChild(middleArea);
					BinDiv.appendChild(bottomArea);
					newDivElement.appendChild(BinDiv);
			
					// 부모 요소에 새로운 div 요소 추가
					parentElement.insertBefore(newDivElement, parentElement.firstChild);
					document.getElementById("content").value = "";
					document.getElementById("count").innerHTML = "0 / 700";
    				document.querySelector('label[for="content"]').style.display = 'block';


				}
			})
			.catch(error => {
				console.error('오류 발생:', error);
			})
		}
}


// 처음 로드시 댓글 출력
document.addEventListener('DOMContentLoaded', function() {
    let formData = new FormData();
	let bId = document.getElementById("bdc_b_id").value;
    formData.append('b_id', bId);
    formData.append('cateNum', 1);
	var cateNumDOM = document.getElementById("categoryBtn1");
	cateNumDOM.className = "bdc-list-cate bdc-list-cate-bold";
    fetch('/book/detail/comment/print', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
		let commentResult = data.commentResult;
        let commentCount = data.commentCount;
        let userLikeResultArr = data.userLikeResultArr;
        let userDislikeResultArr = data.userDislikeResultArr;
		var BinDiv = document.createElement('div');
		var bdcHeadTxtCount = document.getElementById('bdc-head-txt-count');
		bdcHeadTxtCount.innerHTML = commentCount;
		for (let i = 0; i < commentResult.length; i++) {
			var parentElement = document.getElementById('bdc-list');

			// 새로운 div 요소 생성
			var newDivElement = document.createElement('div');
			var StrNum = commentResult[i]['bdc_id'];
			newDivElement.id = "bdc-list-area" + StrNum;
	
			// 리스트 상단 영역 생성
			var topArea = document.createElement('div');
			topArea.className = 'bdc-list-top-area';
	
			var imgElement = document.createElement('img');
			imgElement.className = 'bdc-list-area-img';
			imgElement.src = '/img/user.png';
			imgElement.alt = '';
	
			var nameElement = document.createElement('span');
			nameElement.className = 'bdc-list-area-name';
			nameElement.textContent = commentResult[i]['u_name'];
	
			var dateElement = document.createElement('span');
			dateElement.className = 'bdc-list-area-at';
			dateElement.textContent = new Date(commentResult[i]['created_at'])
										.toLocaleString('ko-KR', 
											{year: 'numeric', month: '2-digit', day: '2-digit', hour: 'numeric', minute: 'numeric', hour12: false});
	
			topArea.appendChild(imgElement);
			topArea.appendChild(nameElement);
			topArea.appendChild(dateElement);

			// 리스트 중단 영역 생성
			var middleArea = document.createElement('div');
			middleArea.className = 'bdc-list-middle-area font-1';
	
			var contentElement = document.createElement('p');
			contentElement.className = 'bdc-list-area-content';
			contentElement.textContent = commentResult[i]['bdc_comment'];
	
			middleArea.appendChild(contentElement);
	
			// 리스트 하단 영역 생성
			var bottomArea = document.createElement('div');
			bottomArea.className = 'bdc-list-bottom-area';
	
			var replyLink = document.createElement('a');
			replyLink.className = 'bdc-list-area-reply';
			replyLink.textContent = '답글';
			replyLink.onclick = function() {
				var StrNum = commentResult[i]['bdc_id'];
				replyOpen(StrNum);
			};

			var replyCount = document.createElement('span');
			replyCount.className = 'bdc-list-area-reply-cnt';
			replyCount.textContent = commentResult[i]['reply_count'];
			replyCount.id = 'bdc-list-area-reply-cnt' + StrNum;
	
			replyLink.appendChild(replyCount);
	
			var recommendArea = document.createElement('div');
			recommendArea.className = 'bdc-list-recommend-area';
	
			var likeBox = document.createElement('a');
			likeBox.className = 'bdc-list-area-like-box';
			likeBox.id = 'bdc-list-area-like-box' + StrNum;
			likeBox.onclick = function() {
				var StrNum = commentResult[i]['bdc_id'];
				likeInsert(StrNum);
			};

			if(userLikeResultArr.includes(commentResult[i]['bdc_id'])) {
				likeBox.classList.add('book_detail_likein_user');
			}

			var likeImg = document.createElement('img');
			likeImg.className = 'bdc-dis-like-btn';
			likeImg.src = '/img/book_detail_like.png';
			likeImg.alt = '';
	
			var likeCount = document.createElement('span');
			likeCount.textContent = commentResult[i]['like'];
			var StrNum = commentResult[i]['bdc_id'];
			likeCount.id= 'like-count' + StrNum;
			likeBox.appendChild(likeImg);
			likeBox.appendChild(likeCount);
	
			var dislikeBox = document.createElement('a');
			dislikeBox.className = 'bdc-list-area-dislike-box';
			dislikeBox.id = 'bdc-list-area-dislike-box' + StrNum;
			dislikeBox.onclick = function() {
				var StrNum = commentResult[i]['bdc_id'];
				dislikeInsert(StrNum);
			};
			if(userDislikeResultArr.includes(commentResult[i]['bdc_id'])) {
				dislikeBox.classList.add('book_detail_likein_user');
			}

			var dislikeImg = document.createElement('img');
			dislikeImg.className = 'bdc-dis-like-btn';
			dislikeImg.src = '/img/book_detail_dislike.png';
			dislikeImg.alt = '';
	
			var dislikeCount = document.createElement('span');
			dislikeCount.textContent = commentResult[i]['dislike'];
			dislikeCount.id= 'dislike-count' + StrNum;
	
			dislikeBox.appendChild(dislikeImg);
			dislikeBox.appendChild(dislikeCount);
	
			recommendArea.appendChild(likeBox);
			recommendArea.appendChild(dislikeBox);
	
			bottomArea.appendChild(replyLink);
			bottomArea.appendChild(recommendArea);
	
			var BinDiv = document.createElement('div');
			BinDiv.className = 'bdc-list-area';

			// 새로운 div 요소에 생성한 영역들 추가
			BinDiv.appendChild(topArea);
			BinDiv.appendChild(middleArea);
			BinDiv.appendChild(bottomArea);

			newDivElement.appendChild(BinDiv);
	
			// 부모 요소에 새로운 div 요소 추가
			parentElement.appendChild(newDivElement);
		}

		})
		.catch(error => {
			console.error('오류 발생:', error);
		})
});


function categoryBtn(cateNum) {
	let formData = new FormData();
	let bId = document.getElementById("bdc_b_id").value;
	formData.append('b_id', bId);
	formData.append('cateNum', cateNum);
	var cateBtnDiv = document.getElementById("categoryBtnDiv");
	var cateNumStr = 'categoryBtn' + cateNum;
	var cateNumDOM = document.getElementById(cateNumStr);

	var ChildElements = cateBtnDiv.querySelectorAll('*');
	ChildElements.forEach(function(element) {
		element.classList = "bdc-list-cate";
	});
	cateNumDOM.className = "bdc-list-cate bdc-list-cate-bold";

	fetch('/book/detail/comment/print', {
		method: 'POST',
		body: formData,
	})
	.then(response => response.json())
	.then(data => {
		var parentElement = document.getElementById('bdc-list');
		while (parentElement.firstChild) {
			parentElement.removeChild(parentElement.firstChild);
		}
		let commentResult = data.commentResult;
		let commentCount = data.commentCount;
		let userLikeResultArr = data.userLikeResultArr;
		let userDislikeResultArr = data.userDislikeResultArr;
		var BinDiv = document.createElement('div');
		var bdcHeadTxtCount = document.getElementById('bdc-head-txt-count');
		bdcHeadTxtCount.innerHTML = commentCount;
		for (let i = 0; i < commentResult.length; i++) {
			var parentElement = document.getElementById('bdc-list');

			// 새로운 div 요소 생성
			var newDivElement = document.createElement('div');
			var StrNum = commentResult[i]['bdc_id'];
			newDivElement.id = "bdc-list-area" + StrNum;
	
			// 리스트 상단 영역 생성
			var topArea = document.createElement('div');
			topArea.className = 'bdc-list-top-area';
	
			var imgElement = document.createElement('img');
			imgElement.className = 'bdc-list-area-img';
			imgElement.src = '/img/user.png';
			imgElement.alt = '';
	
			var nameElement = document.createElement('span');
			nameElement.className = 'bdc-list-area-name';
			nameElement.textContent = commentResult[i]['u_name'];
	
			var dateElement = document.createElement('span');
			dateElement.className = 'bdc-list-area-at';
			dateElement.textContent = new Date(commentResult[i]['created_at'])
										.toLocaleString('ko-KR', 
											{year: 'numeric', month: '2-digit', day: '2-digit', hour: 'numeric', minute: 'numeric', hour12: false});
	
			topArea.appendChild(imgElement);
			topArea.appendChild(nameElement);
			topArea.appendChild(dateElement);

			// 리스트 중단 영역 생성
			var middleArea = document.createElement('div');
			middleArea.className = 'bdc-list-middle-area font-1';
	
			var contentElement = document.createElement('p');
			contentElement.className = 'bdc-list-area-content';
			contentElement.textContent = commentResult[i]['bdc_comment'];
	
			middleArea.appendChild(contentElement);
	
			// 리스트 하단 영역 생성
			var bottomArea = document.createElement('div');
			bottomArea.className = 'bdc-list-bottom-area';
	
			var replyLink = document.createElement('a');
			replyLink.className = 'bdc-list-area-reply';
			replyLink.textContent = '답글';
			replyLink.onclick = function() {
				var StrNum = commentResult[i]['bdc_id'];
				replyOpen(StrNum);
			};

			var replyCount = document.createElement('span');
			replyCount.className = 'bdc-list-area-reply-cnt';
			replyCount.textContent = commentResult[i]['reply_count'];
			replyCount.id = 'bdc-list-area-reply-cnt' + StrNum;
	
			replyLink.appendChild(replyCount);
	
			var recommendArea = document.createElement('div');
			recommendArea.className = 'bdc-list-recommend-area';
	
			var likeBox = document.createElement('a');
			likeBox.className = 'bdc-list-area-like-box';
			likeBox.id = 'bdc-list-area-like-box' + StrNum;
			likeBox.onclick = function() {
				var StrNum = commentResult[i]['bdc_id'];
				likeInsert(StrNum);
			};

			if(userLikeResultArr.includes(commentResult[i]['bdc_id'])) {
				likeBox.classList.add('book_detail_likein_user');
			}

			var likeImg = document.createElement('img');
			likeImg.className = 'bdc-dis-like-btn';
			likeImg.src = '/img/book_detail_like.png';
			likeImg.alt = '';
	
			var likeCount = document.createElement('span');
			likeCount.textContent = commentResult[i]['like'];
			var StrNum = commentResult[i]['bdc_id'];
			likeCount.id= 'like-count' + StrNum;
			likeBox.appendChild(likeImg);
			likeBox.appendChild(likeCount);
	
			var dislikeBox = document.createElement('a');
			dislikeBox.className = 'bdc-list-area-dislike-box';
			dislikeBox.id = 'bdc-list-area-dislike-box' + StrNum;
			dislikeBox.onclick = function() {
				var StrNum = commentResult[i]['bdc_id'];
				dislikeInsert(StrNum);
			};
			if(userDislikeResultArr.includes(commentResult[i]['bdc_id'])) {
				dislikeBox.classList.add('book_detail_likein_user');
			}

			var dislikeImg = document.createElement('img');
			dislikeImg.className = 'bdc-dis-like-btn';
			dislikeImg.src = '/img/book_detail_dislike.png';
			dislikeImg.alt = '';
	
			var dislikeCount = document.createElement('span');
			dislikeCount.textContent = commentResult[i]['dislike'];
			dislikeCount.id= 'dislike-count' + StrNum;
	
			dislikeBox.appendChild(dislikeImg);
			dislikeBox.appendChild(dislikeCount);
	
			recommendArea.appendChild(likeBox);
			recommendArea.appendChild(dislikeBox);
	
			bottomArea.appendChild(replyLink);
			bottomArea.appendChild(recommendArea);
	
			var BinDiv = document.createElement('div');
			BinDiv.className = 'bdc-list-area';

			// 새로운 div 요소에 생성한 영역들 추가
			BinDiv.appendChild(topArea);
			BinDiv.appendChild(middleArea);
			BinDiv.appendChild(bottomArea);

			newDivElement.appendChild(BinDiv);
	
			// 부모 요소에 새로운 div 요소 추가
			parentElement.appendChild(newDivElement);
		}

		})
		.catch(error => {
			console.error('오류 발생:', error);
		})
}
// 답글 클릭시
let clickedIds = [];

function replyOpen(bdc_id) {
	if (!clickedIds.includes(bdc_id)) {
		clickedIds.push(bdc_id);
		let formData = new FormData();
		formData.append('bdc_id', bdc_id);

		fetch('/book/detail/reply/print', {
			method: 'POST',
			body: formData,
		})
		.then(response => response.json())
		.then(data => {
			let replyResult = data.replyResult;
			let strNum = "bdc-list-area" + bdc_id;
			let parentElement = document.getElementById(strNum);
			let acFlg = document.getElementById("ac_flg").value;
			let userLikeResultArr = data.userLikeResultArr;
			let userDislikeResultArr = data.userDislikeResultArr;
			if(acFlg == 1 ) {
				var uName = document.getElementById("u_name").value;
			}

			for (let i = 0; i < replyResult.length; i++) {
				// 새로운 댓글 영역을 생성
				var newReplyArea = document.createElement('div');
				newReplyArea.className = 'bdc-list-reply-area';

				// 리스트 상단 영역 생성
				var topArea = document.createElement('div');
				topArea.className = 'bdc-list-top-area';

				// 이미지 생성
				var imgElement = document.createElement('img');
				imgElement.className = 'bdc-list-area-img';
				imgElement.src = '/img/user.png';

				// 이름 생성
				var nameElement = document.createElement('span');
				nameElement.className = 'bdc-list-area-name';
				nameElement.textContent = replyResult[i]['u_name'];

				// 시간 생성
				var timeElement = document.createElement('span');
				timeElement.className = 'bdc-list-area-at';
				timeElement.textContent = new Date(replyResult[i]['created_at'])
											.toLocaleString('ko-KR', 
												{year: 'numeric', month: '2-digit', day: '2-digit', hour: 'numeric', minute: 'numeric', hour12: false});


				// 리스트 중단 영역 생성
				var middleArea = document.createElement('div');
				middleArea.className = 'bdc-list-middle-area font-1';

				var contentElement = document.createElement('p');
				contentElement.className = 'bdc-list-area-content';
				contentElement.textContent = replyResult[i]['bdr_comment'];

				// 리스트 하단 영역 생성
				var bottomArea = document.createElement('div');
				bottomArea.className = 'bdc-list-reply-bottom-area';

				var recommendArea = document.createElement('div');
				recommendArea.className = 'bdc-list-recommend-area';

				// 좋아요 링크 생성
				var likeLink = document.createElement('a');
				likeLink.className = 'bdc-list-area-like-box';
				var replyStrNum = replyResult[i]['bdr_id'];
				likeLink.id = 'bdc-list-area-like-box-reply' + replyStrNum;
				likeLink.onclick = function() {
					var replyStrNum = replyResult[i]['bdr_id'];
					replyLikeInsert(replyStrNum);
				};

				if(userLikeResultArr.includes(replyResult[i]['bdr_id'])) {
					likeLink.classList.add('book_detail_likein_user');
				}
				var likeImage = document.createElement('img');
				likeImage.className = 'bdc-dis-like-btn';
				likeImage.src = '/img/book_detail_like.png';

				var likeCount = document.createElement('span');
				likeCount.textContent = replyResult[i]['like'];
				likeCount.id= 'reply-like-count' + replyStrNum;
				likeLink.appendChild(likeImage);
				likeLink.appendChild(likeCount);
				
				// 싫어요 링크 생성
				var dislikeLink = document.createElement('a');
				dislikeLink.className = 'bdc-list-area-dislike-box';
				dislikeLink.id = 'bdc-list-area-dislike-box-reply' + replyStrNum;
				if(userDislikeResultArr.includes(replyResult[i]['bdr_id'])) {
					dislikeLink.classList.add('book_detail_likein_user');
				}
				dislikeLink.onclick = function() {
					var replyStrNum = replyResult[i]['bdr_id'];
					replyDislikeInsert(replyStrNum);
				};
				var dislikeImage = document.createElement('img');
				dislikeImage.className = 'bdc-dis-like-btn';
				dislikeImage.src = '/img/book_detail_dislike.png';
				dislikeImage.alt = '';

				var dislikeCount = document.createElement('span');
				dislikeCount.textContent = replyResult[i]['dislike'];
				dislikeCount.id= 'reply-dislike-count' + replyStrNum;

				dislikeLink.appendChild(dislikeImage);
				dislikeLink.appendChild(dislikeCount);

				recommendArea.appendChild(likeLink);
				recommendArea.appendChild(dislikeLink);

				bottomArea.appendChild(recommendArea);

				middleArea.appendChild(contentElement);

				topArea.appendChild(imgElement);
				topArea.appendChild(nameElement);
				topArea.appendChild(timeElement);

				newReplyArea.appendChild(topArea);
				newReplyArea.appendChild(middleArea);
				newReplyArea.appendChild(bottomArea);

				// 부모 요소에 새로 생성한 댓글 영역 추가
				parentElement.appendChild(newReplyArea);
			}

			var bdcReplyWriteDiv = document.createElement('div');
			bdcReplyWriteDiv.classList.add('bdc-reply-write');
			bdcReplyWriteDiv.id = 'bdc-reply-write'+bdc_id;

			var bdcWriteDiv = document.createElement('div');
			bdcWriteDiv.classList.add('bdc-write');

			var profileAreaDiv = document.createElement('div');
			profileAreaDiv.classList.add('bdc-profile-area');

			var profileImg = document.createElement('img');
			profileImg.classList.add('bdc-profile-img');
			profileImg.src = '/img/user.png';
			profileImg.alt = '';

			profileAreaDiv.appendChild(profileImg);

			if( acFlg == 1 ) {
				var profileName = document.createElement('p');
				profileName.classList.add('bdc-profile-name');
				profileName.textContent = uName;
				profileAreaDiv.appendChild(profileName);
			} else if (acFlg == 2) {
				var profileNoName = document.createElement('p');
				profileNoName.classList.add('bdc-profile-noname');
				profileNoName.textContent = '로그인 후 이용 바랍니다.';
				profileAreaDiv.appendChild(profileNoName);
			}

			var writeBoxDiv = document.createElement('div');
			writeBoxDiv.classList.add('bdc-reply-write-box');

			var writeInboxAreaDiv = document.createElement('div');
			writeInboxAreaDiv.classList.add('bdc-write-inbox-area', 'font-1');

			var replyContentTextarea = document.createElement('textarea');
			replyContentTextarea.classList.add('bdc-reply-write-area');
			replyContentTextarea.id = 'replycontent'+bdc_id;
			replyContentTextarea.rows = '5';
			replyContentTextarea.cols = '30';
			replyContentTextarea.name = 'replycontent';
			replyContentTextarea.maxlength = '301';

			if( acFlg == 2 ) {
				replyContentTextarea.onclick = loginCheckConfirm;
			}
			
			replyContentTextarea.oninput = function() {
				replyLimitCharacters(bdc_id);
				replyHandleInput(this, bdc_id);
			};
			var writeLabel = document.createElement('label');
			writeLabel.classList.add('bdc-write-label');
			writeLabel.htmlFor = 'replycontent'+bdc_id;
			if( acFlg == 1 ) {
				writeLabel.innerHTML = '다양한 의견이 서로 존중될 수 있도록 다른 사람에게 불쾌감을 주는 욕설, 혐오, 비하의 ' +
									'표현이나 타인의 권리를 침해하는 내용은 주의해주세요. ' +
									'모든 작성자는 ' +
									'<span class="bdc-write-label-span">' +
									'본인이 작성한 의견에 대해 법적 책임을 갖는다는 점' +
									'</span>' +
									' 유의하시기 바랍니다.';
			} else if(acFlg == 2) {
				writeLabel.textContent = '로그인 후 이용 바랍니다.';
			}
			
			writeInboxAreaDiv.appendChild(replyContentTextarea);
			writeInboxAreaDiv.appendChild(writeLabel);

			writeBoxDiv.appendChild(writeInboxAreaDiv);
			var writeUploadDiv = document.createElement('div');
			writeUploadDiv.classList.add('bdc-write-upload');

			var replyCountSpan = document.createElement('span');
			replyCountSpan.classList.add('bdc-write-upload-cnt');
			replyCountSpan.id = 'replycount'+bdc_id;
			replyCountSpan.textContent = '0 / 700';

			var uploadButton = document.createElement('button');
			uploadButton.type = 'button';
			uploadButton.classList.add('bdc-write-upload-btn');

			if( acFlg == 2 ) {
				uploadButton.onclick = loginCheckConfirm;
			} else if(acFlg == 1) {
				uploadButton.onclick = function() {
					replyInsertFormCheck(bdc_id);
				};
			}

			uploadButton.textContent = '등록';

			writeUploadDiv.appendChild(replyCountSpan);
			writeUploadDiv.appendChild(uploadButton);

			bdcWriteDiv.appendChild(profileAreaDiv);
			bdcWriteDiv.appendChild(writeBoxDiv);
			bdcWriteDiv.appendChild(writeUploadDiv);

			bdcReplyWriteDiv.appendChild(bdcWriteDiv);
			parentElement.appendChild(bdcReplyWriteDiv);

			var divElement = document.createElement("div");
			divElement.classList.add('bdc-reply-fold-box');
			var buttonElement = document.createElement("button");
			buttonElement.classList.add('bdc-reply-fold-item');
			buttonElement.onclick = function() {
				CloseReply(bdc_id);
			};
			buttonElement.innerHTML = "답글 접기 ∧";

			divElement.appendChild(buttonElement);
			parentElement.appendChild(divElement);
		})
		.catch(error => {
			console.error('오류 발생:', error);
		})
	} else {
		let strNum = "bdc-list-area" + bdc_id;
		let parentElement = document.getElementById(strNum);
		var childElements = parentElement.children;
		for (var i = 0; i < childElements.length; i++) {
			childElements[i].classList.toggle('display-none');
		}
	}
}

// 답글 닫기
function CloseReply(bdc_id) {
	let strNum = "bdc-list-area" + bdc_id;
	let parentElement = document.getElementById(strNum);
	var childElements = parentElement.children;
		for (var i = 0; i < childElements.length; i++) {
			childElements[i].classList.toggle('display-none');
		}
}

// 대댓글 insert
function replyInsertFormCheck(bdc_id) {
	let contentStr = 'replycontent' + bdc_id;
	let contentValue = document.getElementById(contentStr).value;
	if (contentValue.trim() === "") {
		alert("내용을 입력해주세요.");
	} else {
		let formData = new FormData();
			let bId = document.getElementById("bdc_b_id").value;
			formData.append('b_id', bId);
			formData.append('content', contentValue);
			formData.append('bdc_id', bdc_id);
			fetch('/book/detail/reply/insert', {
				method: 'POST',
				body: formData,
			})
			.then(response => response.json())
			.then(data => {
				let errorMsg = data.errorMsg;
				if(errorMsg) {
					if(confirm("로그인을 하신 후 이용해 주시기 바랍니다.")){
						window.location.href = "/login";
					}
				} else {
					// 주 처리부분
					let replyResult = data.commentResult;
					let uNameResult = data.uNameResult;
					let contentStr = 'replycontent' + bdc_id;
					let labelStr = 'label[for="replycontent'+bdc_id+'"]';
					let countStr = 'replycount' + bdc_id;
					let ParentStr = 'bdc-reply-write' + bdc_id;

					let bdcListAreaReplyStr = 'bdc-list-area-reply-cnt' + bdc_id;
					var bdcListAreaReplyDOM = document.getElementById(bdcListAreaReplyStr);
					var currentCount = parseInt(bdcListAreaReplyDOM.innerHTML, 10);
					var newCount = currentCount + 1;
					bdcListAreaReplyDOM.innerHTML = newCount;

					var parentElement = document.getElementById(ParentStr);

					var newReplyArea = document.createElement('div');
					newReplyArea.className = 'bdc-list-reply-area';
	
					// 리스트 상단 영역 생성
					var topArea = document.createElement('div');
					topArea.className = 'bdc-list-top-area';
	
					// 이미지 생성
					var imgElement = document.createElement('img');
					imgElement.className = 'bdc-list-area-img';
					imgElement.src = '/img/user.png';
	
					// 이름 생성
					var nameElement = document.createElement('span');
					nameElement.className = 'bdc-list-area-name';
					nameElement.textContent = uNameResult.u_name;
	
					// 시간 생성
					var timeElement = document.createElement('span');
					timeElement.className = 'bdc-list-area-at';
					timeElement.textContent = new Date(replyResult['created_at'])
												.toLocaleString('ko-KR', 
													{year: 'numeric', month: '2-digit', day: '2-digit', hour: 'numeric', minute: 'numeric', hour12: false});
	
	
					// 리스트 중단 영역 생성
					var middleArea = document.createElement('div');
					middleArea.className = 'bdc-list-middle-area font-1';
	
					var contentElement = document.createElement('p');
					contentElement.className = 'bdc-list-area-content';
					contentElement.textContent = replyResult['bdr_comment'];
	
					// 리스트 하단 영역 생성
					var bottomArea = document.createElement('div');
					bottomArea.className = 'bdc-list-reply-bottom-area';
	
					var recommendArea = document.createElement('div');
					recommendArea.className = 'bdc-list-recommend-area';
	
					var replyStrNum = replyResult['bdr_id'];
					// 좋아요 링크 생성
					var likeLink = document.createElement('a');
					likeLink.className = 'bdc-list-area-like-box';
					likeLink.id = 'bdc-list-area-like-box-reply' + replyStrNum;
					likeLink.onclick = function() {
						var replyStrNum = replyResult['bdr_id'];
						replyLikeInsert(replyStrNum);
					};
					var likeImage = document.createElement('img');
					likeImage.className = 'bdc-dis-like-btn';
					likeImage.src = '/img/book_detail_like.png';
	
					var likeCount = document.createElement('span');
					likeCount.textContent = '0';
					likeCount.id= 'reply-like-count' + replyStrNum;
	
					likeLink.appendChild(likeImage);
					likeLink.appendChild(likeCount);
	
					// 싫어요 링크 생성
					var dislikeLink = document.createElement('a');
					dislikeLink.className = 'bdc-list-area-dislike-box';
					dislikeLink.id = 'bdc-list-area-dislike-box-reply' + replyStrNum;
					dislikeLink.onclick = function() {
						var replyStrNum = replyResult['bdr_id'];
						replyDislikeInsert(replyStrNum);
					};
					var dislikeImage = document.createElement('img');
					dislikeImage.className = 'bdc-dis-like-btn';
					dislikeImage.src = '/img/book_detail_dislike.png';
					dislikeImage.alt = '';
	
					var dislikeCount = document.createElement('span');
					dislikeCount.textContent = '0';
					dislikeCount.id= 'reply-dislike-count' + replyStrNum;
	
					dislikeLink.appendChild(dislikeImage);
					dislikeLink.appendChild(dislikeCount);
	
					recommendArea.appendChild(likeLink);
					recommendArea.appendChild(dislikeLink);
	
					bottomArea.appendChild(recommendArea);
	
					middleArea.appendChild(contentElement);
	
					topArea.appendChild(imgElement);
					topArea.appendChild(nameElement);
					topArea.appendChild(timeElement);
	
					newReplyArea.appendChild(topArea);
					newReplyArea.appendChild(middleArea);
					newReplyArea.appendChild(bottomArea);


					parentElement.parentNode.insertBefore(newReplyArea, parentElement);
					document.getElementById(contentStr).value = "";
					document.getElementById(countStr).innerHTML = "0 / 700";
    				document.querySelector(labelStr).style.display = 'block';
				}
			})
			.catch(error => {
				console.error('오류 발생:', error);
			})
	}
}

// 댓글 좋아요 생성
function likeInsert(bdc_id) {

	let formData = new FormData();
		let ac_flg = document.getElementById("ac_flg").value;
		if(ac_flg==="1") {
			formData.append('bdc_id', bdc_id);
			fetch('/book/detail/comment/like', {
				method: 'POST',
				body: formData,
			})
			.then(response => response.json())
			.then(data => {
				let errorMsg = data.errorMsg;
				if(errorMsg) {
					if(confirm("로그인을 하신 후 이용해 주시기 바랍니다.")){
						window.location.href = "/login";
					}
				} else {
					
					let likeCountStr = 'like-count' + bdc_id;
					document.getElementById(likeCountStr).innerHTML = data.likeCountResult;
					let likeBoxStr = 'bdc-list-area-like-box' + bdc_id;
					let likeBoxElement = document.getElementById(likeBoxStr);
					likeBoxElement.classList.toggle('book_detail_likein_user');
				}
			})
			.catch(error => {
				console.error('오류 발생:', error);
			})
		}
		else if(ac_flg ==="2") {
			if(confirm("로그인을 하신 후 이용해 주시기 바랍니다.")){
				window.location.href = "/login";
			} else {
			}
		}
}

// 댓글 싫어요 생성
function dislikeInsert(bdc_id) {

	let formData = new FormData();
		let ac_flg = document.getElementById("ac_flg").value;
		if(ac_flg==="1") {
			formData.append('bdc_id', bdc_id);
			fetch('/book/detail/comment/dislike', {
				method: 'POST',
				body: formData,
			})
			.then(response => response.json())
			.then(data => {
				let errorMsg = data.errorMsg;
				if(errorMsg) {
					if(confirm("로그인을 하신 후 이용해 주시기 바랍니다.")){
						window.location.href = "/login";
					}
				} else {
					
					let dislikeCountStr = 'dislike-count' + bdc_id;
					document.getElementById(dislikeCountStr).innerHTML = data.dislikeCountResult;
					let dislikeBoxStr = 'bdc-list-area-dislike-box' + bdc_id;
					let dislikeBoxElement = document.getElementById(dislikeBoxStr);
					dislikeBoxElement.classList.toggle('book_detail_likein_user');
				}
			})
			.catch(error => {
				console.error('오류 발생:', error);
			})
		}
		else if(ac_flg ==="2") {
			if(confirm("로그인을 하신 후 이용해 주시기 바랍니다.")){
				window.location.href = "/login";
			} else {
			}
		}
}

// 대댓글 좋아요 생성
function replyLikeInsert(bdr_id) {

	let formData = new FormData();
		let ac_flg = document.getElementById("ac_flg").value;
		if(ac_flg==="1") {
			formData.append('bdr_id', bdr_id);
			fetch('/book/detail/reply/like', {
				method: 'POST',
				body: formData,
			})
			.then(response => response.json())
			.then(data => {
				let errorMsg = data.errorMsg;
				if(errorMsg) {
					if(confirm("로그인을 하신 후 이용해 주시기 바랍니다.")){
						window.location.href = "/login";
					}
				} else {
					let likeCountStr = 'reply-like-count' + bdr_id;
					document.getElementById(likeCountStr).innerHTML = data.likeCountResult;
					let likeBoxStr = 'bdc-list-area-like-box-reply' + bdr_id;
					let likeBoxElement = document.getElementById(likeBoxStr);
					likeBoxElement.classList.toggle('book_detail_likein_user');
				}
			})
			.catch(error => {
				console.error('오류 발생:', error);
			})
		}
		else if(ac_flg ==="2") {
			if(confirm("로그인을 하신 후 이용해 주시기 바랍니다.")){
				window.location.href = "/login";
			} else {
			}
		}
}

// 대댓글 싫어요 생성
function replyDislikeInsert(bdr_id) {

	let formData = new FormData();
		let ac_flg = document.getElementById("ac_flg").value;
		if(ac_flg==="1") {
			formData.append('bdr_id', bdr_id);
			fetch('/book/detail/reply/dislike', {
				method: 'POST',
				body: formData,
			})
			.then(response => response.json())
			.then(data => {
				let errorMsg = data.errorMsg;
				if(errorMsg) {
					if(confirm("로그인을 하신 후 이용해 주시기 바랍니다.")){
						window.location.href = "/login";
					}
				} else {
					
					let dislikeCountStr = 'reply-dislike-count' + bdr_id;
					document.getElementById(dislikeCountStr).innerHTML = data.dislikeCountResult;
					let dislikeBoxStr = 'bdc-list-area-dislike-box-reply' + bdr_id;
					let dislikeBoxElement = document.getElementById(dislikeBoxStr);
					dislikeBoxElement.classList.toggle('book_detail_likein_user');
				}
			})
			.catch(error => {
				console.error('오류 발생:', error);
			})
		}
		else if(ac_flg ==="2") {
			if(confirm("로그인을 하신 후 이용해 주시기 바랍니다.")){
				window.location.href = "/login";
			} else {
			}
		}
}