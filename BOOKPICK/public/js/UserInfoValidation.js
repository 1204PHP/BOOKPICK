document.addEventListener('DOMContentLoaded', function() {
    // 폼 전송 이벤트 리스너 등록
    document.querySelector('.info-form').addEventListener('submit', function(event) {
        // 폼 전송 전에 유효성 검사 수행
        if (!isValid()) {
            event.preventDefault(); // 폼 전송 중단
        }
    });
});
    var new_password = document.getElementById("new_password");
    var password_confirm = document.getElementById("password_confirm");
    var u_postcode = document.getElementById("u_postcode");
    var u_basic_address = document.getElementById("u_basic_address");
    var u_detail_address = document.getElementById("u_detail_address");

    // 각 입력 필드에 대한 유효성 검사를 수행하는 함수
    function validateInput(inputField) {
        var errorSpan = inputField.nextElementSibling;

        if (!inputField.value) {
            // 값이 없는 경우, input 테두리 초기화
            inputField.style.border = "1px solid #ccc";
            clearErrorMsg(errorSpan);
            inputField.style.marginBottom = "10px";
        } else {
            // 값이 있는 경우, 유효성 검사 수행
            var isValid = true;

            // 각 필드에 따른 추가적인 유효성 검사 규칙을 적용하고 결과에 따라 isValid를 업데이트
            if (inputField.id === "new_password") {
                isValid = validatePassword(inputField);
            } else if (inputField.id === "password_confirm") {
                isValid = validatePasswordConfirm(document.getElementById("new_password"), inputField);
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
                inputField.style.marginBottom = "10px";
            } else {
                inputField.style.border = "3px solid red";
                inputField.style.marginBottom = "0px";
            }

            if (isValid) {
                clearErrorMsg(errorSpan);
            }
        }
        return isValid;
    }

    // 각 입력 필드에 대한 input 이벤트 리스너 등록
    var inputFields = [new_password, password_confirm, u_postcode, u_basic_address, u_detail_address];

    for (let i = 0; i < inputFields.length; i++) {
        inputFields[i].addEventListener("input", function (event) {
            validateInput(event.target);
        });
    }

    // new password 유효성 검사
    function validatePassword(passwordInput) {
        var passwordValid = true;
        var passwordErrorSpan = document.querySelector(".new_password_errormsg");
        var passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;

        if (passwordInput) {
            if (!passwordInput.value) {
                passwordValid = false;
                openErrorMsg(passwordErrorSpan, "비밀번호를 입력해주세요");
            } else if (!passwordRegex.test(passwordInput.value) || passwordInput.value.length > 20) {
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
        var confirmPasswordInputErrorSpan = document.querySelector(".password_confirm_errormsg");

        if (confirmPasswordInput) {
            if (!confirmPasswordInput.value) {
                passwordConfirmValid = false;
                openErrorMsg(confirmPasswordInputErrorSpan, "비밀번호를 한번 더 입력해주세요");
            } else if (passwordInput.value !== confirmPasswordInput.value) {
                passwordConfirmValid = false;
                openErrorMsg(confirmPasswordInputErrorSpan, "비밀번호와 일치하지 않습니다");
            } else {
                clearErrorMsg(confirmPasswordInputErrorSpan);
            }
        }
        return passwordConfirmValid;
    }

    // 우편번호 유효성 검사
    function validatePostcode(postcodeInput) {
        var postcodeValid = true;
        var postcodeErrorSpan = document.querySelector(".u_postcode_errormsg");
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
        var basicAddressErrorSpan = document.querySelector(".u_basic_address_errormsg");
        var basicAddressValidRegex = /^[ㄱ-ㅎㅏ-ㅣ가-힣0-9a-zA-Z\s-]*$/;

        if (basicAddressInput) {
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
