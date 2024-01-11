document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('query');

    searchInput.addEventListener('input', function () {
        const query = searchInput.value;

        fetch(`/query-autosearch?query=${query}`)
            .then(response => response.json())
            .then(data => {
                // Query Suggestions을 화면에 표시하는 로직 작성
                console.log(data.autoSearch); // 받아온 연관 검색어를 콘솔에 출력

                // 여기서 받아온 연관 검색어를 화면에 표시하는 로직을 작성
                // 예를 들어, 결과를 ul 태그에 동적으로 추가하는 방법
                const suggestionsList = document.getElementById('auto-search');
                suggestionsList.innerHTML = ''; // 기존 목록 초기화

                data.autoSearch.forEach(suggestion => {
                    const li = document.createElement('li');
                    li.textContent = suggestion.b_sub_cate + ' - ' + suggestion.b_title;
                    suggestionsList.appendChild(li);
                });
            })
            .catch(error => {
                console.error('Error:', error); // 오류가 발생한 경우 콘솔에 오류를 출력
            });
    });
});