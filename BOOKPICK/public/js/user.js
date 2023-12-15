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
    var form = document.getElementsByClassName("login-form");

    form.addEventListener("submit", function (event) {
        event.preventDefault(); // 기본 제출 동작을 막음

        // 각 입력 필드에 대한 유효성 검사
        var userEmailValid = validationEmailForm();

        // 유효성 검사를 통과하면 폼을 제출
        if (userEmailValid) {
            form.submit();
        } else if(userPasswordValid) {
            form.submit();
        }
    });

    // 각 입력 필드에 대한 유효성 검사를 수행하는 함수
    function validationEmailForm() {
        var userEmailValid = true;
    
        // 이메일 유효성 검사
        var emailInput = document.getElementById("u_email");
        var emailErrorSpan = document.getElementsByClassName("u_mail_errormsg");
        var emailRegex = /^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,}$/;
    
        if (!emailInput.value) {
            userEmailValid = false;
            emailErrorSpan.innerText = "이메일: 필수 정보입니다.";
        } else if (!emailRegex.test(emailInput.value)) {
            userEmailValid = false;
            emailErrorSpan.innerText = "이메일: 올바른 이메일 형식이 아닙니다.";
        } else {
            // 서버에 중복 여부 확인 (unique)
            // 예를 들어, 서버 측에 Ajax 요청을 보내서 중복 여부를 확인할 수 있음
            emailUniqueCheck(emailInput.value, function (isUnique) {
                if (!isUnique) {
                    userEmailValid = false;
                    emailErrorSpan.innerText = "이메일: 이미 사용 중인 이메일입니다.";
                } else {
                    emailErrorSpan.innerText = "";
                }
            });
        }    
        return userEmailValid;
    }
});