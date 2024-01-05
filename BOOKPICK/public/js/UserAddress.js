// 회원 가입 주소 검색
function execDaumPostcode() {
    daum.postcode.load(function() {
        new daum.Postcode({
            oncomplete: function(data) {
                var addr = ''; // 주소 변수

                //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                    addr = data.roadAddress;
                } else { // 사용자가 지번 주소를 선택했을 경우(J)
                    addr = data.jibunAddress;
                }

                // 버튼 클릭 시 주소검색 팝업 오픈
                document.getElementById('register-postcode-button').addEventListener('click', execDaumPostcode);

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('u_postcode').value = data.zonecode;
                document.getElementById("u_basic_address").value = addr;
                // 커서를 상세주소 필드로 이동한다.
                document.getElementById("u_detail_address").focus();
            }
        }).open();
    });
}


// 회원정보 수정 주소 검색
function addressSearch() {
    daum.postcode.load(function() {
        new daum.Postcode({
            oncomplete: function(data) {
                var addr = '';

                // 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                    addr = data.roadAddress;
                } else { // 사용자가 지번 주소를 선택했을 경우(J)
                    addr = data.jibunAddress;
                }

                // 버튼 클릭 시 주소검색 팝업 오픈
                document.getElementById('info-postcode-button').addEventListener('click', addressSearch);

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('u_postcode').value = data.zonecode;
                document.getElementById("u_basic_address").value = addr;
                // 커서를 상세주소 필드로 이동한다.
                document.getElementById("u_detail_address").focus();
            }
        }).open();
    });
}




