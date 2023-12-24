document.addEventListener("DOMContentLoaded", function () {
    var form = document.querySelector(".info-form");
    var csrfToken = document.querySelector('meta[name="csrf-token"]');
    var csrfTokenValue = csrfToken ? csrfToken.getAttribute('content') : null;

    var new_password = document.getElementById("new_password");
    var password_confirm = document.getElementById("password_confirm");
    var u_postcode = document.getElementById("u_postcode");
    var u_basic_address = document.getElementById("u_basic_address");
    var u_detail_address = document.getElementById("u_detail_address");

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        // 필요한 데이터에 대한 유효성 검사 수행
        var newPasswordValid = validatePassword(new_password);
        var passwordConfirmValid = validatePasswordConfirm(new_password, password_confirm);
        var postcodeValid = validatePostcode(u_postcode);
        var basicAddressValid = validateBasicAddress(u_basic_address);
        var detailAddressValid = validateBasicAddress(u_detail_address);

        if (newPasswordValid && passwordConfirmValid && postcodeValid && basicAddressValid && detailAddressValid) {
            // 유효성 검사 통과 시 폼 제출
            form.submit();
        } else {
            // 필수 항목을 입력하지 않았을 경우
            alert("필수 항목을 입력해주세요");
        }
    });

    function validatePassword(passwordInput) {
        var passwordValid = true;
        var passwordErrorSpan = document.getElementsByClassName("u_password_errormsg")[0];
        var passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;
        
        if(passwordInput) {
            if (!passwordInput.value) {
                passwordValid = false;
                setInvalidInput(passwordInput, passwordErrorSpan, "비밀번호를 입력해주세요");
            } else if (!passwordRegex.test(passwordInput.value) || passwordInput.value.length > 21) {
                passwordValid = false;
                setInvalidInput(passwordInput, passwordErrorSpan, "보안강도 약함(8~20자 문자+숫자+특수문자 포함필요)");
            } else {
                setValidInput(passwordInput, passwordErrorSpan);
            }
        }  
        return passwordValid;
    }

    function validatePasswordConfirm(passwordInput, confirmPasswordInput) {
        var passwordConfirmValid = true;
        var passwordConfirmErrorSpan = document.getElementsByClassName("u_password_confirm_errormsg")[0];

        if (confirmPasswordInput) {
            if (!confirmPasswordInput.value) {
                passwordConfirmValid = false;
                setInvalidInput(confirmPasswordInput, passwordConfirmErrorSpan, "비밀번호를 한번 더 입력해주세요");
            } else if (passwordInput.value !== confirmPasswordInput.value) {
                passwordConfirmValid = false;
                setInvalidInput(confirmPasswordInput, passwordConfirmErrorSpan, "비밀번호와 일치하지 않습니다");
            } else {
                setValidInput(confirmPasswordInput, passwordConfirmErrorSpan);
            }
        }
        return passwordConfirmValid;
    }

    function validatePostcode(postcodeInput) {
        var postcodeValid = true;
        var postcodeErrorSpan = document.getElementsByClassName("u_postcode_errormsg")[0];
        var postcodeRegex = /^\d{5}$/;
    
        if (postcodeInput) {
            if (!postcodeInput.value) {
                postcodeValid = false;
                setInvalidInput(postcodeInput, postcodeErrorSpan, "우편번호: 필수 정보입니다.");
            } else if (!postcodeRegex.test(postcodeInput.value || postcodeInput.value.length > 6)) {
                postcodeValid = false;
                setInvalidInput(postcodeInput, postcodeErrorSpan, "우편번호는 5자리 숫자로만 입력해주세요");
            } else {
                setValidInput(postcodeInput, postcodeErrorSpan);
            }
        }
        return postcodeValid;
    }

    function validateBasicAddress(basicAddressInput) {
        var basicAddressValid = true;
        var basicAddressErrorSpan = document.getElementsByClassName("u_postcode_errormsg")[0];
        var basicAddressValidRegex = /^[ㄱ-ㅎㅏ-ㅣ가-힣0-9a-zA-Z-]*$/;
        
        if(basicAddressInput) {
            if (!basicAddressInput.value) {
                basicAddressValid = false;
                setInvalidInput(basicAddressInput, basicAddressErrorSpan, "기본주소를 입력해주세요");
            } else if (!basicAddressValidRegex.test(basicAddressInput.value || basicAddressInput.value.length > 201)) {
                basicAddressValid = false;
                setInvalidInput(basicAddressInput, basicAddressErrorSpan, "기본주소는 한글, 숫자, 영어, -를 포함하여 입력해주세요");
            } else {
                setValidInput(basicAddressInput, basicAddressErrorSpan);
            }
        }  
        return basicAddressValid;
    }

    function setInvalidInput(inputField, errorSpan, errorMessage) {
        inputField.style.border = "3px solid red";
        openErrorMsg(errorSpan, errorMessage);
    }

    function setValidInput(inputField, errorSpan) {
        inputField.style.border = "3px solid #53A73C";
        clearErrorMsg(errorSpan);
    }

    function openErrorMsg(element, message) {
        // 내용이 비어있지 않으면 오류 메시지 표시
        if (message.trim() !== "") {
            element.innerText = message;
        } else {
            // 내용이 비어있으면 오류 메시지 감춤
            clearErrorMsg(element);
        }
    }

    function clearErrorMsg(element) {
        if (element) {
            element.innerText = "";
        }
    }
});
