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
                if(query.length >= 2 && isKorean(query)) {
                    if (query.trim() !== '') {
                        fetchData(query);
                    } else {
                        // 입력값이 없을 경우 autoSearchArea를 숨김
                        autoSearchArea.style.display = 'none';
                    }
                } else {
                    // 입력값이 없을 경우 autoSearchArea를 숨김
                    autoSearchArea.style.display = 'none';
                }
            }
        }, 200);
    });

    function isKorean(text) {
        const KoreanRegex = /[ㄱ-ㅎㅏ-ㅣ가-힣]/;
        return KoreanRegex.test(text);
    }

    function fetchData(query) {
        isLoading = true; // 데이터 로딩 중

        // 검색어가 변경될 때만 페이지 초기화
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

                if (data.autoSearch.length === 0) {
                    // 검색결과가 없는 경우 메시지 출력
                    const li = document.createElement('li');
                    li.textContent = '일치하는 결과가 없습니다.';
                    fragment.appendChild(li);
                    // 입력값이 없을 경우 autoSearchArea를 숨김
                    if (data.autoSearch.length === 0 && query.trim() === '') {
                        autoSearchArea.style.display = 'none';
                    } else {
                        autoSearchArea.style.display = 'block';
                        autoSearchArea.style.height = '60px';
                        autoSearchArea.style.overflowY = 'hidden';
                        autoSearchArea.style.border = '2px solid #4dac27';
                    } 
                } else {
                    data.autoSearch.forEach(suggestion => {
                        const li = document.createElement('li');
                        const cateSpan = document.createElement('span');
                        const spaceSpan = document.createElement('span');                    
                        const titleSpan = document.createElement('span');

                        titleSpan.addEventListener('click', function () {
                            const inputValue = suggestion.b_title.replace(/ - .*$/, '');
                            searchInput.value = inputValue;
                            submitSearch();
                        });
                        cateSpan.addEventListener('click', function () {
                            const inputValue = suggestion.b_sub_cate.replace(/ - .*$/, '');
                            searchInput.value = inputValue;
                            submitSearch();
                        });

                        cateSpan.textContent = suggestion.b_sub_cate;
                        spaceSpan.textContent = '\n';
                        titleSpan.textContent = suggestion.b_title;

                        cateSpan.style.color = '#4dac27';
                        cateSpan.style.fontSize = '1rem';
                        cateSpan.style.textDecoration = 'underline';
                        spaceSpan.style.whiteSpace = 'pre';
                        titleSpan.style.color = '#000';
                        cateSpan.style.fontSize = '0.8rem';
                        titleSpan.style.cursor = 'pointer';
                        cateSpan.style.cursor = 'pointer';

                        li.appendChild(titleSpan);
                        li.appendChild(spaceSpan);
                        li.appendChild(cateSpan);

                        fragment.appendChild(li);
                    });
                    autoSearchArea.style.display = 'block';
                    autoSearchArea.style.height = '220px';
                    autoSearchArea.style.overflowY = 'auto';
                    autoSearchArea.style.border = '2px solid #4dac27';
                }
                suggestionsList.appendChild(fragment);
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

    window.addEventListener('beforeunload', function (event) {
        const searchInput = document.getElementById('query');
        const autoSearchArea = document.getElementById('auto-search-area');
        
        // 페이지 이동시 input 값, 검색데이터 출력ul 초기화
        searchInput.value = '';
        autoSearchArea.style.display = 'none';
    });
});

document.addEventListener('click', function(event) {
    const autoSearchArea = document.getElementById('auto-search-area');
    // const suggestionsList = document.getElementById('auto-search');

    // 클릭된 엘리먼트가 auto-search 영역 안에 있는지 확인
    if (!autoSearchArea.contains(event.target)) {
        // 클릭된 엘리먼트가 auto-search 영역 외부에 있으면 autoSearchArea를 숨김
        autoSearchArea.style.display = 'none';
    }
});
