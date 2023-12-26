document.addEventListener("DOMContentLoaded", function () {
    var forms = document.getElementsByClassName("register-form");
    var csrfToken = document.querySelector('meta[name="csrf-token"]');
    var csrfTokenValue = csrfToken ? csrfToken.getAttribute('content') : null;
    // 이메일 중복 확인 및 유효성 검사 여부를 추적하는 변수
    var isEmailValid = false;

    for (let i = 0; i < forms.length; i++) {
        var form = forms[i];
        var emailConfirmButton = form.querySelector("#emailConfirmButton");

        if (emailConfirmButton) {
            emailConfirmButton.addEventListener("click", function (event) {
                // 이메일 유효성 검사
                var userEmailField = form.querySelector("#u_email");
                // 이메일 중복 확인
                var userEmailValid = validateInput(userEmailField);

                if (userEmailValid) {
                    // 중복 확인 서버 요청
                    checkDuplicateEmail("/api/confirm-email", userEmailField.value, function (isEmailAvailable) {
                        if (isEmailAvailable) {
                            // 0(true) 리턴 시 DB저장 데이터 : 사용가능 이메일(O)
                            alert("사용 가능한 이메일입니다.");
                            // 중복 이메일 확인 상태 업데이트
                            isEmailValid = true;
                            // 타 필드에 대한 유효성 검사만 진행
                            validateOtherFieldsExceptEmail(form);
                            // 이메일 중복 확인 완료 시 다음 단계로 이동
                            proceedToNextStep(form);                            
                        } else {
                            // 1(false) 리턴 시 DB저장 데이터 : 사용가능 이메일(X)
                            alert("이미 사용 중인 이메일입니다.");
                            // 중복 이메일 확인 상태 업데이트
                            isEmailValid = false;
                        }
                    });
                } else {
                    // 이메일 필드가 비어있는 경우
                    alert("이메일을 입력해주세요.");
                    // 중복 이메일 확인 상태 업데이트
                    isEmailValid = false;
                } 
                event.preventDefault();
            });
        }

        var submitButton = form.querySelector("#register-button");
        if (submitButton) {
            submitButton.addEventListener("click", function (event) {
                // 빈 값이 있을 때 폼 제출을 막고 알림 표시
                if (!isEmailValid && !form.querySelector("#u_email").value) {
                    alert("이메일 중복 확인을 먼저 해주세요");
                    event.preventDefault();
                    console.log("이메일 유효성 검사로 인해 폼 제출이 방지되었습니다.");
                } else {
                    // 나머지 필드에 대한 유효성 검사 수행
                    var isOtherFieldsValid = validateOtherFieldsExceptEmail(form);
                    if (!isOtherFieldsValid) {
                        // 폼 제출을 막음
                        event.preventDefault();
                        console.log("다른 필드 유효성 검사로 인해 폼 제출이 방지되었습니다.");
                    } else {
                        console.log("폼이 성공적으로 제출되었습니다.");
                        form.submit();
                    }
                }
            });
        }  

        // 각 입력 필드에 대한 실시간 유효성 검사 등록 << 수정 >>
        var inputFields = form.getElementsByClassName("register-input");
        for (var j = 0; j < inputFields.length; j++) {
            inputFields[j].addEventListener("input", function (event) {                
                console.log("Validating input:", event.target.id);

                // 상세주소 필드인 경우에는 유효성 검사를 무시하도록 추가
                if (event.target.id === "u_detail_address") {
                    return;
                }

                // 중복 이메일 확인 상태 초기화
                isEmailValid = false;
                validateInput(event.target);
            });
        }
    }    

    // 중복 이메일 확인 수행 함수
    function checkDuplicateEmail(apiUrl, userEmail, callback) {
        // fetch를 사용하여 서버에 요청
        fetch(apiUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfTokenValue
            },
            body: JSON.stringify({
                u_email: userEmail,
            }),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data); // 콘솔에 서버 응답 출력

            if (data && data.confirmEmail !== undefined) {
                if (data.confirmEmail === 0) {
                    // 0인 경우 사용 가능한 이메일로 처리
                    callback(true);
                } else {
                    // 0이 아닌 경우 중복된 이메일로 처리
                    callback(false);
                }
            } else {
                callback(false);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            callback(false);
        });
    }    

    // 이메일 입력 후 처리에 대한 함수
    function proceedToNextStep(form) {
        // 이메일 중복 확인 후 이메일 입력란 잠금
        var emailInput = form.querySelector("#u_email");
        emailInput.readOnly = true;
    }

    // 이메일을 제외한 폼 전체 유효성 검사
    function isFormValidExceptEmail() {
        return (
            validateInput(document.getElementById("u_password")) &&
            validateInput(document.getElementById("u_password_confirm")) &&
            validateInput(document.getElementById("u_name")) &&
            validateInput(document.getElementById("u_birthdate")) &&
            validateInput(document.getElementById("u_tel")) &&
            validateInput(document.getElementById("u_postcode")) &&
            validateInput(document.getElementById("u_basic_address"))
        );
    }

    // 각 입력 필드에 대한 유효성 검사를 수행하는 함수
    function validateInput(inputField) {
        console.log("Validating input field:", inputField.id);
        var errorSpan = inputField.parentElement.querySelector('.register-required-span span');

        if (!inputField.value) {
            // 값이 없는 경우, input 테두리 초기화
            inputField.style.border = "1px solid #ccc";
            clearErrorMsg(errorSpan);
            return false;
        } else {
            // 값이 있는 경우, 유효성 검사 수행
            var isValid = true;

            // 각 필드에 따른 추가적인 유효성 검사 규칙을 적용하고 결과에 따라 isValid를 업데이트
            if (inputField.id === "u_email" && !isEmailValid) {
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
            } else if (inputField.id === "u_detail_address") {
                // 상세주소 필드는 필수가 아니므로 유효성 검사를 무시
                isValid = true;
            }

            // 유효성 검사 통과 시 input 테두리 초록색
            // 유효성 검사 실패 시 input 테두리 빨간색
            if (isValid) {
                inputField.style.border = "3px solid #53A73C";
                clearErrorMsg(errorSpan);
            } else {
                inputField.style.border = "3px solid red";
                openErrorMsg(errorSpan);
            }

        }
        return isValid;
    }

    // 다른 필드에 대한 유효성 검사
    function validateOtherFieldsExceptEmail(form) {
        $flg = false;
        // 이메일을 제외한 다른 필드에 대한 유효성 검사 코드 추가
        $flg = validateInput(document.getElementById("u_password"));
        $flg = validateInput(document.getElementById("u_password_confirm"));
        $flg = validateInput(document.getElementById("u_name"));
        $flg = validateInput(document.getElementById("u_birthdate"));
        $flg = validateInput(document.getElementById("u_tel"));
        $flg = validateInput(document.getElementById("u_postcode"));
        $flg = validateInput(document.getElementById("u_basic_address"));

        // 유효성 검사 통과 시 다음 단계로 진행 또는 서버로 전송
        if (isFormValidExceptEmail(form)) {
            alert("회원가입이 완료되었습니다. 로그인을 해주세요");
        } else {
            if(isEmailValid === true) {
            } else {
                // 폼이 유효하지 않은 경우 제출을 막음
                alert("회원정보 입력사항을 다시 확인해주세요");
            }
        }
        return $flg;
    }
});


    // email 유효성 검사
    function validateEmail(emailInput) {
        var emailValid = true;
        var emailErrorSpan = document.querySelector('.u_mail_errormsg');
        var emailRegex = /^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,}$/;

        if (emailInput) {
            if (!emailInput.value) {
                emailValid = false;
                openErrorMsg(emailErrorSpan, "이메일을 입력해주세요");
            } else if (!emailRegex.test(emailInput.value)) {
                emailValid = false;
                openErrorMsg(emailErrorSpan, "이메일을 다시 확인해주세요");
            } else {
                clearErrorMsg(emailErrorSpan);
            }
        }
        return emailValid;
    }

    // password 유효성 검사
    function validatePassword(passwordInput) {        
        var passwordValid = true;
        var passwordErrorSpan = document.querySelector('.u_password_errormsg');
        var passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;
        
        if(passwordInput) {
            if (!passwordInput.value) {
                passwordValid = false;
                openErrorMsg(passwordErrorSpan, "비밀번호를 입력해주세요");
            } else if (!passwordRegex.test(passwordInput.value) || passwordInput.value.length > 21) {
                passwordValid = false;
                openErrorMsg(passwordErrorSpan, "보안강도 약함(8~20자 문자+숫자+특수문자 포함필요)");
            } else {
                clearErrorMsg(passwordErrorSpan);
            }
        }  
        return passwordValid;
    }

    // password 재확인 유효성 검사
    function validatePasswordConfirm(passwordInput, confirmPasswordInput) {
        var passwordConfirmValid = true;
        var passwordConfirmErrorSpan = document.querySelector('.u_password_confirm_errormsg');

        if (confirmPasswordInput) {
            if (!confirmPasswordInput.value) {
                passwordConfirmValid = false;
                openErrorMsg(passwordConfirmErrorSpan, "비밀번호를 한번 더 입력해주세요");
            } else if (passwordInput.value !== confirmPasswordInput.value) {
                passwordConfirmValid = false;
                openErrorMsg(passwordConfirmErrorSpan, "비밀번호와 일치하지 않습니다");
            } else {
                clearErrorMsg(passwordConfirmErrorSpan);
            }
        }
        return passwordConfirmValid;
    }
    
    // name 유효성 검사
    function validateName(nameInput) {
        var nameValid = true;
        var nameErrorSpan = document.querySelector('.u_name_errormsg');
        var nameRegex = /^[가-힣]{1,50}$/;
        
        if(nameInput) {
            if (!nameInput.value) {
                nameValid = false;
                openErrorMsg(nameErrorSpan, "이름을 입력해주세요");
            } else if (!nameRegex.test(nameInput.value || nameInput.value.length > 51)) {
                nameValid = false;
                openErrorMsg(nameErrorSpan, "한글로만 입력해주세요");
            } else {
                clearErrorMsg(nameErrorSpan);
            }
        }  
        return nameValid;
    }
    
    // birthdate 유효성 검사
    function validateBirthdate(birthdateInput) {
        var birthdateValid = true;
        var birthdateErrorSpan = document.querySelector('.u_birthdate_errormsg');
        var birthdateRegex = /^(19|20)\d\d(0[1-9]|1[0-2])(0[1-9]|[12][0-9]|3[01])$/;
        
        if(birthdateInput) {
            if (!birthdateInput.value) {
                birthdateValid = false;
                openErrorMsg(birthdateErrorSpan, "생년월일을 입력해주세요 ex)YYYYMMDD");
            } else if (!birthdateRegex.test(birthdateInput.value || birthdateInput.value.length > 12)) {
                birthdateValid = false;
                openErrorMsg(birthdateErrorSpan, "생년월일을 다시 확인해주세요");
            } else {
                clearErrorMsg(birthdateErrorSpan);
            }
        }  
        return birthdateValid;
    }

    // tel 유효성 검사
    function validateTel(telInput) {
        var telValid = true;
        var telErrorSpan = document.querySelector('.u_tel_errormsg');
        var telRegex = /^010[0-9]{7,8}$/;
        
        if(telInput) {
            if (!telInput.value) {
                telValid = false;
                openErrorMsg(telErrorSpan, "휴대폰 번호를 입력해주세요");
            } else if (!telRegex.test(telInput.value || telInput.value.length > 12)) {
                telValid = false;
                openErrorMsg(telErrorSpan, "휴대폰 번호를 다시 확인해주세요");
            } else {
                clearErrorMsg(telErrorSpan);
            }
        }  
        return telValid;
    }

    // 우편번호 유효성 검사
    function validatePostcode(postcodeInput) {
        var postcodeValid = true;
        var postcodeErrorSpan = document.querySelector('.u_postcode_errormsg');
        var postcodeRegex = /^\d{5}$/;
    
        if (postcodeInput) {
            if (!postcodeInput.value) {
                postcodeValid = false;
                openErrorMsg(postcodeErrorSpan, "우편번호: 필수 정보입니다.");
            } else if (!postcodeRegex.test(postcodeInput.value || postcodeInput.value.length > 6)) {
                postcodeValid = false;
                openErrorMsg(postcodeErrorSpan, "우편번호는 5자리 숫자로만 입력해주세요");
            } else {
                clearErrorMsg(postcodeErrorSpan);
            }
        }
        return postcodeValid;
    }

    // 기본주소 유효성 검사
    function validateBasicAddress(basicAddressInput) {
        var basicAddressValid = true;
        var basicAddressErrorSpan = document.querySelector('.u_basic_address_errormsg');
        var basicAddressValidRegex = /^[ㄱ-ㅎㅏ-ㅣ가-힣0-9a-zA-Z-]*$/;
        
        if(basicAddressInput) {
            if (!basicAddressInput.value) {
                basicAddressValid = false;
                openErrorMsg(basicAddressErrorSpan, "기본주소를 입력해주세요");
            } else if (!basicAddressValidRegex.test(basicAddressInput.value || basicAddressInput.value.length > 201)) {
                basicAddressValid = false;
                openErrorMsg(basicAddressErrorSpan, "기본주소는 한글, 숫자, 영어, -를 포함하여 입력해주세요");
            } else {
                clearErrorMsg(basicAddressErrorSpan);
            }
        }  
        return basicAddressValid;
    }

    function openErrorMsg(element, message) {
        if (element && message && message.trim() !== "") {
            element.innerText = message;
        }
    }

    function clearErrorMsg(element) {
        if (element) {
            element.innerText = "";
        }
    }
