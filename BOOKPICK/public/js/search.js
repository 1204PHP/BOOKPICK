document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('query');
    let timeoutId;
    let page = 1; // 초기 페이지 번호 설정
    let isLoading = false; // 중복 요청 방지용 플래그
    const autoSearchArea = document.getElementById('auto-search-area');

    searchInput.addEventListener('input', function () {
        const query = searchInput.value;

        // 디바운스 적용
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            if (!isLoading) {
                if (query.trim() !== '') {
                    fetchData(query);
                } else {
                    // 입력값이 없을 경우 autoSearchArea를 숨김
                    autoSearchArea.style.display = 'none';
                }
            }
        }, 300);
    });

    function fetchData(query) {
        isLoading = true; // 데이터 로딩 중

        // 이 부분에서 검색어가 변경될 때만 page를 초기화
        if (searchInput.dataset.prevQuery !== query) {
            page = 1;
            searchInput.dataset.prevQuery = query;
        }

        fetch(`/query-autosearch?query=${query}&page=${page}`)
            .then(response => response.json())
            .then(data => {
                const suggestionsList = document.getElementById('auto-search');
                const fragment = document.createDocumentFragment();

                // 검색결과를 받아올 때마다 기존 리스트 초기화
                suggestionsList.innerHTML = '';

                data.autoSearch.forEach(suggestion => {
                    const li = document.createElement('li');
                    const cateSpan = document.createElement('span');
                    const spaceSpan = document.createElement('span');                    
                    const titleSpan = document.createElement('span');

                    li.addEventListener('click', function () {
                        const inputValue = suggestion.b_title.replace(/ - .*$/, '');
                        searchInput.value = inputValue;
                    });

                    cateSpan.textContent = suggestion.b_sub_cate;
                    spaceSpan.textContent = '\n';
                    titleSpan.textContent = suggestion.b_title;

                    cateSpan.style.color = '#4dac27';
                    cateSpan.style.textDecoration = 'underline';
                    spaceSpan.style.whiteSpace = 'pre';
                    titleSpan.style.color = '#000';
                    // titleSpan.style.textDecoration = 'underline';

                    li.appendChild(titleSpan);
                    li.appendChild(spaceSpan);
                    li.appendChild(cateSpan);

                    fragment.appendChild(li);
                });

                suggestionsList.appendChild(fragment);
                autoSearchArea.style.display = 'block';
                isLoading = false; // 데이터 로딩 완료
                page++; // 다음 페이지로 이동
            })
            .catch(error => {
                console.error('Error:', error);
                isLoading = false; // 데이터 로딩 실패 시에도 플래그 해제
            });
    }

    // 스크롤 이벤트 처리
    window.addEventListener('scroll', function () {
        const scrollPosition = window.scrollY;
        const windowHeight = window.innerHeight;
        const bodyHeight = document.body.offsetHeight;

        // 스크롤이 화면 하단에 닿았을 때(fetchData 호출)
        if (scrollPosition + windowHeight >= bodyHeight - 200 && !isLoading) {
            if (searchInput.value.trim() !== '') {
                fetchData(searchInput.value);
            }
        }
    });
});
