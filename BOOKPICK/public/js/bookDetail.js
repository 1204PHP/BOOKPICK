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






// 상세 페이지 댓글 부분 자바스크립트 구현
function handleInput(textarea) {
    // 텍스트 영역의 값이 비어 있으면 레이블을 표시하고, 값이 있는 경우에는 숨깁니다.
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
var scrollPosition = 0;
document.addEventListener('DOMContentLoaded', function () {
	scrollPosition = window.scrollY;
});

function insertFormCheck() {
	const content = document.getElementById("content").value;
	console.log(content);
	if (content.trim() === "") {
		alert("내용을 입력해주세요.");
		return false;
	}
	return true;
}



document.addEventListener('DOMContentLoaded', function() {
    let formData = new FormData();
	let bId = document.getElementById("bdc_b_id").value;
    formData.append('b_id', bId);
    fetch('/book/detail/comment/print', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
		let commentResult = data.commentResult;
        let commentCount = data.commentCount;
		
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
				aaaa(StrNum);
			};

			var replyCount = document.createElement('span');
			replyCount.className = 'bdc-list-area-reply-cnt';
			replyCount.textContent = commentResult[i]['reply_count'];
	
			replyLink.appendChild(replyCount);
	
			var recommendArea = document.createElement('div');
			recommendArea.className = 'bdc-list-recommend-area';
	
			var likeBox = document.createElement('a');
			likeBox.className = 'bdc-list-area-like-box';
	
			var likeImg = document.createElement('img');
			likeImg.className = 'bdc-dis-like-btn';
			likeImg.src = '/img/book_detail_like.png';
			likeImg.alt = '';
	
			var likeCount = document.createElement('span');
			likeCount.textContent = commentResult[i]['like'];

			likeBox.appendChild(likeImg);
			likeBox.appendChild(likeCount);
	
			var dislikeBox = document.createElement('a');
			dislikeBox.className = 'bdc-list-area-dislike-box';
	
			var dislikeImg = document.createElement('img');
			dislikeImg.className = 'bdc-dis-like-btn';
			dislikeImg.src = '/img/book_detail_dislike.png';
			dislikeImg.alt = '';
	
			var dislikeCount = document.createElement('span');
			dislikeCount.textContent = commentResult[i]['dislike'];
	
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


let clickedIds = [];

function aaaa(bdc_id) {
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
				nameElement.textContent = '정**';

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

				var likeImage = document.createElement('img');
				likeImage.className = 'bdc-dis-like-btn';
				likeImage.src = '/img/book_detail_like.png';

				var likeCount = document.createElement('span');
				likeCount.textContent = '254';

				likeLink.appendChild(likeImage);
				likeLink.appendChild(likeCount);

				// 싫어요 링크 생성
				var dislikeLink = document.createElement('a');
				dislikeLink.href = '#';
				dislikeLink.className = 'bdc-list-area-dislike-box';

				var dislikeImage = document.createElement('img');
				dislikeImage.className = 'bdc-dis-like-btn';
				dislikeImage.src = '/img/book_detail_dislike.png';
				dislikeImage.alt = '';

				var dislikeCount = document.createElement('span');
				dislikeCount.textContent = '1';

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

			
		})
		.catch(error => {
			console.error('오류 발생:', error);
		})
	} else {
		
	}
}