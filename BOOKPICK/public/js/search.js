document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('query');
    let timeoutId;
    let page = 1;
    let isLoading = false;
    const autoSearchArea = document.getElementById('auto-search-area');
    let cachedResults = {};

    searchInput.addEventListener('input', function () {
        const query = searchInput.value.trim();

        // 디바운스 적용
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            if (!isLoading) {
                if (query.length >= 2 && isKorean(query)) {
                    if (query !== '') {
                        // 이전에 받아온 결과가 캐시에 있는지 확인
                        if (cachedResults[query]) {
                            displayResults(cachedResults[query]);
                        } else {
                            fetchData(query);
                        }
                    } else {
                        // 입력값이 없을 경우 autoSearchArea를 숨김
                        autoSearchArea.style.display = 'none';
                    }
                } else {
                    // 입력값이 없거나 2글자 미만이면 autoSearchArea를 숨김
                    autoSearchArea.style.display = 'none';
                }
            }
        }, 300);
    });

    function isKorean(text) {
        const KoreanRegex = /[ㄱ-ㅎㅏ-ㅣ가-힣]/;
        return KoreanRegex.test(text);
    }

    function fetchData(query) {
        isLoading = true;

        // 검색어가 변경될 때만 페이지 초기화
        if (searchInput.dataset.prevQuery !== query) {
            page = 1;
            searchInput.dataset.prevQuery = query;
        }

        fetch(`/query-autosearch?query=${query}&page=${page}`)
            .then(response => response.json())
            .then(data => {
                if (data.autoSearch.length === 0) {
                    // 검색결과가 없는 경우 캐시에 저장하지 않음
                    autoSearchArea.style.display = 'none';
                } else {
                    // 검색결과가 있는 경우 캐시에 저장
                    cachedResults[query] = data;
                    displayResults(data);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            })
            .finally(() => {
                isLoading = false;
                page++;
            });
    }

    function displayResults(data) {
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
            cateSpan.style.fontSize = '1rem';
            cateSpan.style.textDecoration = 'underline';
            spaceSpan.style.whiteSpace = 'pre';
            titleSpan.style.color = '#000';
            titleSpan.style.cursor = 'pointer';

            li.appendChild(titleSpan);
            li.appendChild(spaceSpan);
            li.appendChild(cateSpan);

            fragment.appendChild(li);
        });

        autoSearchArea.style.display = 'block';
        autoSearchArea.style.height = '150px';
        autoSearchArea.style.overflowY = 'auto';
        autoSearchArea.style.border = '2px solid #4dac27';

        suggestionsList.appendChild(fragment);
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

    document.addEventListener('click', function (event) {
        const autoSearchArea = document.getElementById('auto-search-area');
    
        if (event.target.closest('#auto-search-area')) {
            return;
        }
        // autoSearchArea 외 none
        autoSearchArea.style.display = 'none';
    });
});


