// user_register 우편번호 최대길이 10 설정 함수
function limitPostalCodeLength(inputElement) {
	const maxLength = 10;
	// 우편번호 최대 길이 10설정
	let inputValue = inputElement.value.replace(/\D/g, '');
	// 현재 입력값을 가져와서 숫자만 남기기  
	if (inputValue.length > maxLength) {
		inputValue = inputValue.slice(0, maxLength);
		// 최대 길이를 초과시 잘라내기
	}
	inputElement.value = inputValue;
	// 값 설정
};

document.addEventListener("DOMContentLoaded", function () {
    // 폼 요소 참조
    const form = document.querySelector('.login-form');

    // 폼 제출 이벤트 리스너 추가
    form.addEventListener('submit', async function (event) {
        event.preventDefault(); // 폼 제출 중단

        // FormData를 사용하여 폼 데이터를 가져옴
        const formData = new FormData(form);

        try {
            // 서버로 데이터를 전송하고 응답을 받음
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData
            });

            // JSON 형태로 변환된 응답을 가져옴
            const responseData = await response.json();

            // 유효성 검사 오류 메시지를 동적으로 표시
            validationErrors(responseData.errors);
        } catch (error) {
            console.error('Error during form submission:', error);
        }
    });

    // 유효성 검사 오류 메시지를 동적으로 표시하는 함수
    function validationErrors(errors) {
        // 모든 오류 메시지 초기화
        clearErrorMsg();

        // 각 필드에 대한 오류 메시지 표시
        for (const fieldName in errors) {
            if (errors.hasOwnProperty(fieldName)) {
                const errorSpan = form.querySelector(`.error-msg[data-field="${fieldName}"]`);
                if (errorSpan) {
                    errorSpan.textContent = errors[fieldName][0];
                }
            }
        }
    }

    // 모든 오류 메시지를 초기화하는 함수
    function clearErrorMsg() {
        const errorMsgs = form.querySelectorAll('.error-msg');
        errorMsgs.forEach(span => span.textContent = '');
    }
});