document.addEventListener("DOMContentLoaded", function () {
    var loader = document.querySelector('.loading-animation');

    // 페이지 로딩 완료 후 숨김 처리
    loader.style.display = 'none';

    // 페이지 이동 이벤트 감지
    window.addEventListener('beforeunload', function () {
        loader.style.display = 'flex';
        document.body.classList.add('loading');
    });
});