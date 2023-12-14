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