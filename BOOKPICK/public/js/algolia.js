// 입력값에 대한 연관 검색어 통신
function fetchSearchResults(query) {
    // Ajax 요청을 통해 연관 검색어 데이터를 가져옴
    // 여기서는 /searchAlgolia 경로에 해당하는 컨트롤러 메소드로 요청을 보냄
    // Laravel의 경우, 컨트롤러 메소드에서 연관 검색어를 반환하는 것을 가정
    fetch(`/searchAlgolia?query=${query}`)
        .then(response => response.json())
        .then(data => {
            // 검색어에 대한 연관 검색어를 보여줄 공간
            const algoliaSearchResult = document.querySelector('.algolia-search-result');

            // 기존의 내용을 지우고 새로운 연관 검색어를 추가
            algoliaSearchResult.innerHTML = '';

            // 받아온 연관 검색어를 반복하며 리스트에 추가
            data.forEach(result => {
                const relatedSearchLink = document.createElement('a');
                relatedSearchLink.href = result.link; // 해당 검색어에 대한 링크 설정
                relatedSearchLink.textContent = result.label; // 검색어 라벨 설정
                algoliaSearchResult.appendChild(relatedSearchLink);
            });
        })
        .catch(error => console.error('Error fetching search results:', error));
}

// 입력값이 변경될 때마다 호출되는 함수
function handleInputChange() {
    const query = document.querySelector('.search-bar').value;

    // 최소 길이를 설정하여 일정 이상의 길이의 입력값에 대해서만 검색어 요청을 보냄
    if (query.length >= 3) {
        fetchSearchResults(query);
    }
}

// 검색어 입력란에 이벤트 리스너 등록
document.querySelector('.search-bar').addEventListener('input', handleInputChange);
