document.addEventListener("DOMContentLoaded", function () {
    var isEmailValid = false;
    var forms = document.getElementsByClassName("verification-form");
    var csrfToken = document.querySelector('meta[name="csrf-token"]');
    var csrfTokenValue = csrfToken ? csrfToken.getAttribute('content') : null;
    // 이메일 중복 확인 및 유효성 검사 여부를 추적하는 변수

    for (let i = 0; i < forms.length; i++) {
        var form = forms[i];
        var emailConfirmButton = form.querySelector("#emailConfirmButton");


        if (emailConfirmButton) {
            emailConfirmButton.addEventListener("click", function (event) {
                // 이메일 유효성 검사
                var userEmailField = form.querySelector("#u_email");
                // 이메일 중복 확인
                var userEmailValid = validateInput(userEmailField);
                // isEmailValid = validateInput(userEmailField, isEmailValid);

                if (userEmailValid) {
                    // 중복 확인 서버 요청
                    checkDuplicateEmail("/api/confirm-email", userEmailField.value, function (isEmailAvailable) {
                        if (isEmailAvailable) {
                            // 0(true) 리턴 시 DB저장 데이터 : 사용가능 이메일(O)
                            alert("사용 가능한 이메일입니다.");
                            // 중복 이메일 확인 상태 업데이트
                            isEmailValid = true;                       
                        } else {
                            // 1(false) 리턴 시 DB저장 데이터 : 사용가능 이메일(X)
                            alert("이미 사용 중인 이메일입니다.");
                            // 중복 이메일 확인 상태 업데이트
                            isEmailValid = false;
                        }
                    });
                } else {
                    // 이메일 값 미 입력 시
                    alert("이메일을 입력해주세요.");
                    // 중복 이메일 확인 상태 업데이트
                    isEmailValid = false;
                } 
                event.preventDefault();
            });
        }
        
        var submitButton = form.querySelector("#verification-button");
        if (submitButton) {
            submitButton.addEventListener("click", function (event) {
                // 이메일 유효성 검사 실패 & 이메일 값 미입력 시
                if (!isEmailValid && !form.querySelector("#u_email").value) {
                    alert("이메일 입력 또는 중복 확인을 먼저 해주세요");
                    event.preventDefault();
                } else {
                        alert("회원가입이 완료되었습니다. 로그인을 해주세요");
                        form.submit();
                }                
            });
        }
        
        var inputFields = form.getElementsByClassName("verification-input");
        for (var j = 0; j < inputFields.length; j++) {
            inputFields[j].addEventListener("input", function (event) {
                // 중복 이메일 확인 상태 초기화
                isEmailValid = false;
                validateInput(event.target);
            });
        }        
    }

    // 중복 이메일 확인(DB와 통신)
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
                throw new Error('중복 확인 중 오류가 발생했습니다.');
            }
            return response.json();
        })
        .then(data => {
            // console.log(data); 0, 1로 리턴 
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
            console.error("오류:", error);
            callback(false);
        });
    }    
});

// 이메일 입력 값에 대한 유효성 검사
function validateInput(inputField, isEmailValid) {
    var errorSpan = inputField.parentElement.querySelector('.errormsg');
    var isValid = true;

    if (!inputField.value) {
        // 값이 없는 경우, input 테두리 초기화 + margin bottom 10px 추가 + 에러메세지 초기화
        inputField.style.border = "1px solid #ccc";
        inputField.style.marginBottom = "10px";
        clearErrorMsg(errorSpan);
        isValid = false;
    } else {

        // 입력 값에 대한 유효성 검사
        if (inputField.id === "u_email" && !isEmailValid) {
            isValid = validateEmail(inputField);
        } 

        if (isValid) {
            // 유효성 검사 통과 시 input 테두리 초록색 + margin bottom 10px 추가 + 에러메세지 초기화
            inputField.style.border = "2px solid #53A73C";
            inputField.style.marginBottom = "10px";
            clearErrorMsg(errorSpan);
        } else {
            // 유효성 검사 실패 시 input 테두리 빨간색 + margin bottom 0 설정 + 에러메세지 출력
            inputField.style.border = "2px solid red";
            inputField.style.marginBottom = "0px";
            openErrorMsg(errorSpan);
        }
    }
    return isValid;
}

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