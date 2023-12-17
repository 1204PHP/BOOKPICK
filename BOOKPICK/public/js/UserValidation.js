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


// ### 회원가입 실시간 유효성 검사 ###

document.addEventListener("DOMContentLoaded", function () {
    var forms = document.getElementsByClassName("register-form");

    for (let i = 0; i < forms.length; i++) {
        var form = forms[i];

        // 각 입력 필드에 대한 유효성 검사를 수행 함수 등록
        var inputFields = form.getElementsByClassName("register-input");
        for (var j = 0; j < inputFields.length; j++) {
            inputFields[j].addEventListener("input", function (event) {
                validateInput(event.target);
            });
        }

        // form 제출 동작 막음
        form.addEventListener("submit", function (event) {
            event.preventDefault();

            // 각 입력 필드에 대한 유효성 검사
            var userEmailValid = validateInput(document.getElementById("u_email"));
            var userPasswordValid = validateInput(document.getElementById("u_password"));
            var userNameValid = validateInput(document.getElementById("u_name"));
            var userBirthdatedValid = validateInput(document.getElementById("u_birthdate"));
            var userTelValid = validateInput(document.getElementById("u_tel"));
            var userPostCodeValid = validateInput(document.getElementById("u_postcode"));
            var userBasicAddressValid = validateInput(document.getElementById("u_basic_address"));
            var userDetailAddressValid = validateInput(document.getElementById("u_detail_address"));

            // 유효성 검사를 통과하면 해당 폼을 제출
            if (userEmailValid && userPasswordValid && userNameValid
                && userBirthdatedValid && userTelValid && userPostCodeValid
                && userBasicAddressValid && userDetailAddressValid) {
                event.currentTarget.submit();
            }
        });
    }

    // 각 입력 필드에 대한 유효성 검사를 수행하는 함수
    function validateInput(inputField) {
        var isValid = true;
        var errorSpan = inputField.nextElementSibling; // 다음 형제 요소에 오류 메시지가 있다고 가정

        if (!inputField.value) {
            isValid = false;
            openErrorMsg(errorSpan, inputField.placeholder + ": 필수 정보입니다.");
        } else {
            // 각 필드에 따른 추가적인 유효성 검사 규칙을 적용하고 결과에 따라 isValid를 업데이트
            if (inputField.id === "u_email") {
                isValid = validateEmail(inputField);
            } else if (inputField.id === "u_password") {
                isValid = validatePassword(inputField);
            } else if (inputField.id === "u_name") {
                isValid = validateName(inputField);
            } else if (inputField.id === "u_birthdate") {
                isValid = validateBirthdate(inputField);
            } else if (inputField.id === "u_tel") {
                isValid = validateTel(inputField);
            } else if (inputField.id === "u_postcode") {
                isValid = validatePostcode(inputField);
            } else if (inputField.id === "u_basic_address") {
                isValid = validateBasicAddress(inputField);
            } else if (inputField.id === "u_detail_address") {
                isValid = validateDetailAddress(inputField);
            }

            if (isValid) {
                clearErrorMsg(errorSpan);
            }
        }
        return isValid;
    }

    // email 유효성 검사
    function validateEmail(emailInput) {
        var emailValid = true;
        var emailErrorSpan = document.getElementsByClassName("u_mail_errormsg")[0];
        var emailRegex = /^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,}$/;

        if (emailInput) {
            if (!emailInput.value) {
                emailValid = false;
                openErrorMsg(emailErrorSpan, "이메일: 필수 정보입니다.");
            } else if (!emailRegex.test(emailInput.value)) {
                emailValid = false;
                openErrorMsg(emailErrorSpan, "이메일: 올바른 이메일 형식이 아닙니다.");
            } else {
                clearErrorMsg(emailErrorSpan);
            }
        }
        return emailValid;
    }

    // ### 이메일 중복 체크 처리 ###
    // else {
    //     // 서버에 중복 여부 확인 (unique)
    //     // 예를 들어, 서버 측에 Ajax 요청을 보내서 중복 여부를 확인할 수 있음
    //     emailUniqueCheck(emailInputField.value, function (isUnique) {
    //         if (!isUnique) {
    //             emailValid = false;
    //             openErrorMsg(emailErrorSpan, "이메일: 이미 사용 중인 이메일입니다.");
    //         } else {
    //             clearErrorMsg(emailErrorSpan);
    //         }
    //     });
    // }

    // password 유효성 검사
    function validatePassword(passwordInput) {        
        var passwordValid = true;
        var passwordErrorSpan = document.getElementsByClassName("u_password_errormsg")[0];
        var passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;
        
        if(passwordInput) {
            if (!passwordInput.value) {
                passwordValid = false;
                openErrorMsg(passwordErrorSpan, "비밀번호: 필수 정보입니다.");
            } else if (!passwordRegex.test(passwordInput.value || nameInput.value.length > 21)) {
                passwordValid = false;
                openErrorMsg(passwordErrorSpan, "비밀번호: 보안강도 약함(8~20자 문자+숫자+특수문자 포함필요)");
            } else {
                clearErrorMsg(passwordErrorSpan);
            }
        }  
        return passwordValid;
    }
    
    // name 유효성 검사
    function validateName(nameInput) {
        var nameValid = true;
        var nameErrorSpan = document.getElementsByClassName("u_name_errormsg")[0];
        var nameRegex = /^[가-힣]{1,50}$/;
        
        if(nameInput) {
            if (!nameInput.value) {
                nameValid = false;
                openErrorMsg(nameErrorSpan, "이름: 필수 정보입니다.");
            } else if (!nameRegex.test(nameInput.value || nameInput.value.length > 51)) {
                nameValid = false;
                openErrorMsg(nameErrorSpan, "이름: 한글로만 입력가능 합니다");
            } else {
                clearErrorMsg(nameErrorSpan);
            }
        }  
        return nameValid;
    }
    
    // birthdate 유효성 검사
    function validateBirthdate(birthdateInput) {
        var birthdateValid = true;
        var birthdateErrorSpan = document.getElementsByClassName("u_birthdate_errormsg")[0];
        var birthdateRegex = /^(19|20)\d\d-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/;
        
        if(birthdateInput) {
            if (!birthdateInput.value) {
                birthdateValid = false;
                openErrorMsg(birthdateErrorSpan, "생년월일: 필수 정보입니다.");
            } else if (!birthdateRegex.test(birthdateInput.value || birthdateInput.value.length > 12)) {
                birthdateValid = false;
                openErrorMsg(birthdateErrorSpan, "생년월일: 8자리 숫자로만 입력가능 합니다.");
            } else {
                clearErrorMsg(birthdateErrorSpan);
            }
        }  
        return birthdateValid;
    }

    // tel 유효성 검사
    function validateTel(telInput) {
        var telValid = true;
        var telErrorSpan = document.getElementsByClassName("u_tel_errormsg")[0];
        var telRegex = /^010[0-9]{3,4}[0-9]{4}$/;
        
        if(telInput) {
            if (!telInput.value) {
                telValid = false;
                openErrorMsg(telErrorSpan, "휴대폰 번호: 필수 정보입니다.");
            } else if (!telRegex.test(telInput.value || telInput.value.length > 12)) {
                telValid = false;
                openErrorMsg(telErrorSpan, "휴대폰 번호: 휴대폰 번호가 정확하지 않습니다.");
            } else {
                clearErrorMsg(telErrorSpan);
            }
        }  
        return telValid;
    }

    // 우편번호 유효성 검사
    function validatePostcode(postcodeInput) {
        var postcodeValid = true;
        var postcodeErrorSpan = document.getElementsByClassName("u_postcode_errormsg")[0];
        var postcodeRegex = /^\d{5}$/;
        
        if(postcodeInput) {
            if (!postcodeInput.value) {
                postcodeValid = false;
                openErrorMsg(postcodeErrorSpan, "우편번호: 필수 정보입니다.");
            } else if (!postcodeRegex.test(postcodeInput.value || birthdateInput.value.length > 7)) {
                postcodeValid = false;
                openErrorMsg(postcodeErrorSpan, "우편번호: 5~6자리 숫자로만 입력가능 합니다.");
            } else {
                clearErrorMsg(postcodeErrorSpan);
            }
        }  
        return postcodeValid;
    }

    // 기본주소 유효성 검사
    function validateBasicAddress(basicAddressInput) {
        var basicAddressValid = true;
        var basicAddressErrorSpan = document.getElementsByClassName("u_postcode_errormsg")[0];
        var basicAddressValidRegex = /^[ㄱ-ㅎㅏ-ㅣ가-힣0-9a-zA-Z-]*$/;
        
        if(basicAddressInput) {
            if (!basicAddressInput.value) {
                basicAddressValid = false;
                openErrorMsg(basicAddressErrorSpan, "기본주소: 필수 정보입니다.");
            } else if (!basicAddressValidRegex.test(basicAddressInput.value || basicAddressInput.value.length > 201)) {
                basicAddressValid = false;
                openErrorMsg(basicAddressErrorSpan, "기본주소: 한글, 숫자, 영어, - 만 입력가능 합니다.");
            } else {
                clearErrorMsg(basicAddressErrorSpan);
            }
        }  
        return basicAddressValid;
    }

    // 상세주소 유효성
    function validateDetailAddress(detailAddressInput) {
        var detailAddressValid = true;
        var detailAddressErrorSpan = document.getElementsByClassName("u_postcode_errormsg")[0];
        var detailAddressRegex = /^[ㄱ-ㅎㅏ-ㅣ가-힣0-9a-zA-Z-]*$/;
        
        if(detailAddressInput) {
            if (!detailAddressRegex.test(detailAddressInput.value || detailAddressInput.value.length > 51)) {
                detailAddressValid = false;
                openErrorMsg(postcodeErrorSpan, "상세주소: 한글, 숫자, 영어, - 만 입력가능 합니다.");
            } else {
                clearErrorMsg(detailAddressErrorSpan);
            }
        }  
        return detailAddressValid;
    }

    function openErrorMsg(element, message) {
        if (element) {
            element.innerText = message;
        }
    }

    function clearErrorMsg(element) {
        if (element) {
            element.innerText = "";
        }
    }
});