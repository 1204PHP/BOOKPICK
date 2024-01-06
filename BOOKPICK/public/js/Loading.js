document.addEventListener("DOMContentLoaded", function () {
    var loader = document.querySelector('.loading-animation');
    var isLoading = false;

    // 페이지 로딩 완료 후 숨김 처리
    loader.style.display = 'none';

    // 뒤로가기 이벤트 감지
    window.addEventListener('popstate', function () {
        loader.style.display = 'flex';
        document.body.classList.add('loading');
        isLoading = true;
    });

    // 페이지 이동이 완료된 후 로딩 상태 초기화
    window.addEventListener('load', function () {
        if (isLoading) {
            loader.style.display = 'none';
            document.body.classList.remove('loading');
            isLoading = false;
        }
    });
});
