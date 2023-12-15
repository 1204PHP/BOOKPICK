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

// 로그인 실시간 유효성 검사
document.addEventListener("DOMContentLoaded", function () {
    var form = document.getElementsByClassName("login-form");

    form.addEventListener("submit", function (event) {
        event.preventDefault(); // 기본 제출 동작을 막음

        // 각 입력 필드에 대한 유효성 검사
        var userEmailValid = validationEmailForm();
        var userPasswordValid = validationPasswordForm();

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

    // 각 입력 필드에 대한 유효성 검사를 수행하는 함수
    function validationPasswordForm() {
        var userPasswordValid = true;
    
        // 비밀번호 유효성 검사
        var passwordInput = document.getElementById("u_password");
        var passwordErrorSpan = document.getElementsByClassName("u_password_errormsg");
        var passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]+$/;
    
        if (!passwordInput.value) {
            userPasswordValid = false;
            passwordErrorSpan.innerText = "비밀번호: 필수 정보입니다.";
        } else if (!passwordRegex.test(passwordInput.value)) {
            userPasswordValid = false;
            passwordErrorSpan.innerText = "비밀번호: 보안이 취약합니다.";
        } else {
            passwordErrorSpan.innerText = "";
        }
        return userPasswordValid;
    }
});

// 회원가입 실시간 유효성 검사
document.addEventListener("DOMContentLoaded", function () {
    var form = document.getElementsByClassName("register-form");

    form.addEventListener("submit", function (event) {
        event.preventDefault(); 
        // 기본 제출 동작을 막음

        // 각 입력 필드에 대한 유효성 검사
        var userEmailValid = validationEmailForm();
        var userPasswordValid = validationPasswordForm();
        var userNameValid = validationNameForm();
        var userBirthdatedValid = validationBirthdateForm();
        var userTelValid = validationTelForm();
        var userPostCodeValid = validationPostCodeForm();
        var userBasicAddressValid = validationBasicAddressForm();
        var userDetailAddressValid = validationDetailAddressForm();

        // 유효성 검사를 통과하면 폼을 제출
        if (userEmailValid) {
            form.submit();
        } else if(userPasswordValid) {
            form.submit();
        } else if(userNameValid) {
            form.submit();
        } else if(userBirthdatedValid) {
            form.submit();
        } else if(userTelValid) {
            form.submit();
        } else if(userPostCodeValid) {
            form.submit();
        } else if(userBasicAddressValid) {
            form.submit();
        } else if(userDetailAddressValid) {
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

    // 각 입력 필드에 대한 유효성 검사를 수행하는 함수
    function validationPasswordForm() {
        var userPasswordValid = true;
    
        // 비밀번호 유효성 검사
        var passwordInput = document.getElementById("u_password");
        var passwordErrorSpan = document.getElementsByClassName("u_password_errormsg");
        var passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]+$/;
    
        if (!passwordInput.value) {
            userPasswordValid = false;
            passwordErrorSpan.innerText = "비밀번호: 필수 정보입니다.";
        } else if (!passwordRegex.test(passwordInput.value)) {
            userPasswordValid = false;
            passwordErrorSpan.innerText = "비밀번호: 보안이 취약합니다.";
        } else {
            passwordErrorSpan.innerText = "";
        }
        return userPasswordValid;
    }

    function validationNameForm() {
        var userNameValid = true;
    
        // 이름 유효성 검사
        var nameInput = document.getElementById("u_name");
        var nameErrorSpan = document.getElementsByClassName("u_name_errormsg");
        var nameRegex = /^[\p{L}]+$/u;
    
        if (!nameInput.value) {
            userNameValid = false;
            nameErrorSpan.innerText = "이름: 필수 정보입니다.";
        } else if (!nameRegex.test(nameInput.value)) {
            userNameValid = false;
            nameErrorSpan.innerText = "이름: 한글로만 입력가능 합니다.";
        } else {
            nameErrorSpan.innerText = "";
        }
        return userNameValid;
    }

    function validationBirthdateForm() {
        var userBirthdateValid = true;
    
        // 생년월일 유효성 검사
        var birthdateInput = document.getElementById("u_birthdate");
        var birthdateErrorSpan = document.getElementsByClassName("u_birthdate_errormsg");
        var birthdateRegex = /^(19|20)\d\d-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/;
    
        if (!birthdateInput.value) {
            userBirthdateValid = false;
            birthdateErrorSpan.innerText = "생년월일: 필수 정보입니다.";
        } else if (!birthdateRegex.test(birthdateInput.value)) {
            userBirthdateValid = false;
            birthdateErrorSpan.innerText = "생년월일: 8자리 숫자로만 입력가능 합니다.";
        } else {
            birthdateErrorSpan.innerText = "";
        }
        return userBirthdateValid;
    }

    function validationTelForm() {
        var userTelValid = true;
    
        // 휴대폰 번호 유효성 검사
        var telInput = document.getElementById("u_tel");
        var telErrorSpan = document.getElementsByClassName("u_tel_errormsg");
        var telRegex = /^(19|20)\d\d-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/;
    
        if (!telInput.value) {
            userTelValid = false;
            telErrorSpan.innerText = "휴대폰 번호: 필수 정보입니다.";
        } else if (!telRegex.test(telInput.value)) {
            userTelValid = false;
            telErrorSpan.innerText = "휴대폰 번호: 휴대폰 번호가 정확하지 않습니다.";
        } else {
            telErrorSpan.innerText = "";
        }
        return userTelValid;
    }

    function validationPostCodeForm() {
        var userPostCodeValid = true;
    
        // 우편번호 유효성 검사
        var postcodeInput = document.getElementById("u_postcode");
        var postcodeErrorSpan = document.getElementsByClassName("u_postcode_errormsg");
        var postcodeRegex = /^(19|20)\d\d-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/;
    
        if (!postcodeInput.value) {
            userPostCodeValid = false;
            postcodeErrorSpan.innerText = "우편번호: 필수 정보입니다.";
        } else if (!postcodeRegex.test(postcodeInput.value)) {
            userPostCodeValid = false;
            postcodeErrorSpan.innerText = "우편번호: 5자리 숫자로만 입력가능 합니다.";
        } else {
            postcodeErrorSpan.innerText = "";
        }
        return userPostCodeValid;
    }

    function validationBasicAddressForm() {
        var userBasicAddressValid = true;
    
        // 기본주소 유효성 검사
        var basicaddressInput = document.getElementById("u_basic_address");
        var basicaddressErrorSpan = document.getElementsByClassName("u_basic_address_errormsg");
    
        if (!basicaddressInput.value) {
            userBasicAddressValid = false;
            basicaddressErrorSpan.innerText = "기본주소: 필수 정보입니다.";
        } else {
            basicaddressErrorSpan.innerText = "";
        }
        return userBasicAddressValid;
    }

    function validationDetailAddressForm() {
        var userDetailAddressValid = true;
    
        // 상세주소 유효성 검사
        var detailaddressInput = document.getElementById("u_detail_address");
        var detailaddressErrorSpan = document.getElementsByClassName("u_detail_address_errormsg");
    
        if (!detailaddressInput.value) {
            userDetailAddressValid = false;
            detailaddressErrorSpan.innerText = "상세주소: 필수 정보입니다.";
        } else {
            detailaddressErrorSpan.innerText = "";
        }
        return userDetailAddressValid;
    }
});

// 회원정보 수정 실시간 유효성 검사
document.addEventListener("DOMContentLoaded", function () {
    var form = document.getElementsByClassName("info-form");

    form.addEventListener("submit", function (event) {
        event.preventDefault(); 
        // 기본 제출 동작을 막음

        // 각 입력 필드에 대한 유효성 검사
        var userPasswordValid = validationPasswordForm();
        var userPostCodeValid = validationPostCodeForm();
        var userBasicAddressValid = validationBasicAddressForm();
        var userDetailAddressValid = validationDetailAddressForm();

        // 유효성 검사를 통과하면 폼을 제출
        if(userPasswordValid) {
            form.submit();
        } else if(userPostCodeValid) {
            form.submit();
        } else if(userBasicAddressValid) {
            form.submit();
        } else if(userDetailAddressValid) {
            form.submit();
        }
    });

    // 각 입력 필드에 대한 유효성 검사를 수행하는 함수
    function validationPasswordForm() {
        var userPasswordValid = true;
    
        // 비밀번호 유효성 검사
        var passwordInput = document.getElementById("u_password");
        var passwordErrorSpan = document.getElementsByClassName("u_password_errormsg");
        var passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]+$/;
    
        if (!passwordInput.value) {
            userPasswordValid = false;
            passwordErrorSpan.innerText = "비밀번호: 필수 정보입니다.";
        } else if (!passwordRegex.test(passwordInput.value)) {
            userPasswordValid = false;
            passwordErrorSpan.innerText = "비밀번호: 보안이 취약합니다.";
        } else {
            passwordErrorSpan.innerText = "";
        }
        return userPasswordValid;
    }

    function validationPostCodeForm() {
        var userPostCodeValid = true;
    
        // 우편번호 유효성 검사
        var postcodeInput = document.getElementById("u_postcode");
        var postcodeErrorSpan = document.getElementsByClassName("u_postcode_errormsg");
        var postcodeRegex = /^(19|20)\d\d-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/;
    
        if (!postcodeInput.value) {
            userPostCodeValid = false;
            postcodeErrorSpan.innerText = "우편번호: 필수 정보입니다.";
        } else if (!postcodeRegex.test(postcodeInput.value)) {
            userPostCodeValid = false;
            postcodeErrorSpan.innerText = "우편번호: 5자리 숫자로만 입력가능 합니다.";
        } else {
            postcodeErrorSpan.innerText = "";
        }
        return userPostCodeValid;
    }

    function validationBasicAddressForm() {
        var userBasicAddressValid = true;
    
        // 기본주소 유효성 검사
        var basicaddressInput = document.getElementById("u_basic_address");
        var basicaddressErrorSpan = document.getElementsByClassName("u_basic_address_errormsg");
    
        if (!basicaddressInput.value) {
            userBasicAddressValid = false;
            basicaddressErrorSpan.innerText = "기본주소: 필수 정보입니다.";
        } else {
            basicaddressErrorSpan.innerText = "";
        }
        return userBasicAddressValid;
    }

    function validationDetailAddressForm() {
        var userDetailAddressValid = true;
    
        // 상세주소 유효성 검사
        var detailaddressInput = document.getElementById("u_detail_address");
        var detailaddressErrorSpan = document.getElementsByClassName("u_detail_address_errormsg");
    
        if (!detailaddressInput.value) {
            userDetailAddressValid = false;
            detailaddressErrorSpan.innerText = "상세주소: 필수 정보입니다.";
        } else {
            detailaddressErrorSpan.innerText = "";
        }
        return userDetailAddressValid;
    }
});