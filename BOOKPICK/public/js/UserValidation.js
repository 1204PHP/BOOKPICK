// ### 회원가입 실시간 유효성 검사 ###

document.addEventListener("DOMContentLoaded", function () {
    var forms = document.getElementsByClassName("register-form");
    var csrfToken = document.querySelector('meta[name="csrf-token"]');
    var csrfTokenValue = csrfToken ? csrfToken.getAttribute('content') : null;

    for (let i = 0; i < forms.length; i++) {
        var form = forms[i];

        // 각 입력 필드에 대한 유효성 검사를 수행 함수 등록
        var inputFields = form.getElementsByClassName("register-input");
        for (var j = 0; j < inputFields.length; j++) {
            inputFields[j].addEventListener("input", function (event) {
                validateInput(event.target);
            });
        }
        
        // 이메일 중복 체크 버튼 관련 함수
        var emailConfirmButton = form.querySelector("#emailConfirmButton");
        if (emailConfirmButton) {
            emailConfirmButton.addEventListener("click", function (event) {
                event.preventDefault();

                // 각 입력 필드에 대한 유효성 검사
                var userEmailValid = validateInput(document.getElementById("u_email"));

                // 유효성 검사를 통과하면 중복 이메일 확인
                if (userEmailValid) {
                    checkDuplicateEmail("/api/confirm-email", document.getElementById("u_email").value);
                }
            });
        }        

            // 각 입력 필드에 대한 유효성 검사
            var userEmailValid = validateInput(document.getElementById("u_email"));
            var userPasswordValid = validateInput(document.getElementById("u_password"));
            var userPasswordConfirmValid = validateInput(document.getElementById("u_password_confirm"));
            var userNameValid = validateInput(document.getElementById("u_name"));
            var userBirthdatedValid = validateInput(document.getElementById("u_birthdate"));
            var userTelValid = validateInput(document.getElementById("u_tel"));
            var userPostCodeValid = validateInput(document.getElementById("u_postcode"));
            var userBasicAddressValid = validateInput(document.getElementById("u_basic_address"));

    // 각 입력 필드에 대한 유효성 검사를 수행하는 함수
    function validateInput(inputField) {
        var isValid = true;
        var errorSpan = inputField.nextElementSibling; // 다음 형제 요소에 오류 메시지가 있다고 가정

        if (!inputField.value) {
            isValid = false;
            openErrorMsg(errorSpan);
        } else {
            // 각 필드에 따른 추가적인 유효성 검사 규칙을 적용하고 결과에 따라 isValid를 업데이트
            if (inputField.id === "u_email") {
                isValid = validateEmail(inputField);
            } else if (inputField.id === "u_password") {
                isValid = validatePassword(inputField);
            } else if (inputField.id === "u_password_confirm") {
                isValid = validatePasswordConfirm(document.getElementById("u_password"), inputField);
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
            }

            // 유효성 검사 통과 시 input 테두리 초록색
            // 유효성 검사 실패 시 input 테두리 빨간색
            if (isValid) {
                inputField.style.border = "3px solid #53A73C";
            } else {
                inputField.style.border = "3px solid red";
            }

            if (isValid) {
                clearErrorMsg(errorSpan);
            }
        }
        return isValid;
    }

    // form 제출 동작 막음
    form.addEventListener("submit", function (event) {
        event.preventDefault();

    // 유효성 검사를 통과하면 중복 이메일 확인 수행
    if (userEmailValid) {
        checkDuplicateEmail("/api/confirm-email", document.getElementById("u_email").value, function (isAvailable) {
            if (isAvailable) {
                // 중복 이메일 확인이 완료되면 해당 폼을 제출
                if (userPasswordValid && userPasswordConfirmValid 
                    && userNameValid && userBirthdatedValid && userTelValid 
                    && userPostCodeValid && userBasicAddressValid) {
                    form.submit();
                }
            } else {
                alert("이미 사용 중인 이메일입니다.");
            }
        });
    } else {
        // 중복 이메일 확인이 필요하지 않은 경우에도 유효성 검사를 통과하면 해당 폼을 제출
        if (userPasswordValid && userPasswordConfirmValid 
            && userNameValid && userBirthdatedValid && userTelValid 
            && userPostCodeValid && userBasicAddressValid) {
            form.submit();
        }
    }
});


    // 중복 이메일 확인 수행 함수
    function checkDuplicateEmail(apiUrl, userEmail, callback) {
        var inputEmiailConfirm = false;

        // fetch를 사용하여 서버에 요청
        fetch(apiUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfTokenValue
            },
            body: JSON.stringify({
                u_email: userEmail
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.confirmEmail) {
                alert("이미 사용 중인 이메일입니다.");
            } else {
                alert("사용 가능한 이메일입니다.");
            }
        })
        .then(data => {
            callback(data.confirmEmail);
        })
        .catch(error => {
            console.error("Error:", error);
            callback(false);
        });
        return inputEmiailConfirm;
        }
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

    // password 유효성 검사
    function validatePassword(passwordInput) {        
        var passwordValid = true;
        var passwordErrorSpan = document.getElementsByClassName("u_password_errormsg")[0];
        var passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;
        
        if(passwordInput) {
            if (!passwordInput.value) {
                passwordValid = false;
                openErrorMsg(passwordErrorSpan, "비밀번호: 필수 정보입니다.");
            } else if (!passwordRegex.test(passwordInput.value) || passwordInput.value.length > 21) {
                passwordValid = false;
                openErrorMsg(passwordErrorSpan, "비밀번호: 보안강도 약함(8~20자 문자+숫자+특수문자 포함필요)");
            } else {
                clearErrorMsg(passwordErrorSpan);
            }
        }  
        return passwordValid;
    }

    // password 재확인 유효성 검사
    function validatePasswordConfirm(passwordInput, confirmPasswordInput) {
        var passwordConfirmValid = true;
        var passwordConfirmErrorSpan = document.getElementsByClassName("u_password_confirm_errormsg")[0];

        if (confirmPasswordInput) {
            if (!confirmPasswordInput.value) {
                passwordConfirmValid = false;
                openErrorMsg(passwordConfirmErrorSpan, "비밀번호를 한번 더 입력해주세요.");
            } else if (passwordInput.value !== confirmPasswordInput.value) {
                passwordConfirmValid = false;
                openErrorMsg(passwordConfirmErrorSpan, "비밀번호와 일치하지 않습니다.");
            } else {
                clearErrorMsg(passwordConfirmErrorSpan);
            }
        }
        return passwordConfirmValid;
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
        var birthdateRegex = /^(19|20)\d\d(0[1-9]|1[0-2])(0[1-9]|[12][0-9]|3[01])$/;
        
        if(birthdateInput) {
            if (!birthdateInput.value) {
                birthdateValid = false;
                openErrorMsg(birthdateErrorSpan, "생년월일: 필수 정보입니다.");
            } else if (!birthdateRegex.test(birthdateInput.value || birthdateInput.value.length > 12)) {
                birthdateValid = false;
                openErrorMsg(birthdateErrorSpan, "생년월일: 생년월일이 정확하지 않습니다.");
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
        var telRegex = /^010[0-9]{7,8}$/;
        
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
    
        if (postcodeInput) {
            if (!postcodeInput.value) {
                postcodeValid = false;
                openErrorMsg(postcodeErrorSpan, "우편번호: 필수 정보입니다.");
            } else if (!postcodeRegex.test(postcodeInput.value || postcodeInput.value.length > 6)) {
                postcodeValid = false;
                openErrorMsg(postcodeErrorSpan, "우편번호: 5자리 숫자로만 입력가능 합니다.");
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

    function openErrorMsg(element, message) {
        if (element && message) {
            // 내용이 비어있지 않으면 오류 메시지 표시
            if (message.trim() !== "") {
                element.innerText = message;
            } else {
                // 내용이 비어있으면 오류 메시지 감춤
                clearErrorMsg(element);
            }
        }
    }

    function clearErrorMsg(element) {
        if (element) {
            element.innerText = "";
        }
    }

});
