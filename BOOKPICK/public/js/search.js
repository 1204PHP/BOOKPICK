function getAutoSearch() {
    var searchInput = document.getElementById('query').value;

    // Fetch를 사용한 Ajax 요청
    fetch(`/search?query=${searchInput}`)
        .then(response => response.json())
        .then(data => {
            // 검색어 추천 결과를 처리하여 사용자에게 보여줌
            displayAutoSearch(data);
        })
        .catch(error => console.error('Error:', error));
}

function displayAutoSearch(suggestions) {
    var suggestionsList = document.getElementById('suggestionsList'); // <ul id="suggestionsList">
    suggestionsList.innerHTML = '';

    // 검색어 추천 목록을 돌면서 화면에 표시
    suggestions.forEach(function(suggestion) {
        var listItem = document.createElement('li');
        listItem.textContent = suggestion;
        suggestionsList.appendChild(listItem);
    });
}