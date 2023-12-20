document.addEventListener('DOMContentLoaded', function () {
	const toggleBtn = document.getElementsByClassName('navbar__toggleBtn');
	const menu = document.getElementsByClassName('navbar__menu');
	const signin = document.getElementsByClassName('header_signin');
	const toggleBtn1 = document.getElementsByClassName('navbar__toggleBtn1');
	const logo = document.getElementsByClassName('logo_txt');
	const search = document.getElementsByClassName('header_search');

	if (toggleBtn.length > 0) {
		toggleBtn[0].addEventListener('click', function () {
			for (let i = 0; i < menu.length; i++) {
				menu[i].classList.toggle('active');
			}
			for (let i = 0; i < signin.length; i++) {
				signin[i].classList.toggle('active');
			}
		});
	}

	if (toggleBtn1.length > 0) {
		toggleBtn1[0].addEventListener('click', function () {
			for (let i = 0; i < logo.length; i++) {
				logo[i].classList.toggle('active');
			}
			for (let i = 0; i < search.length; i++) {
				search[i].classList.toggle('active');
			}
		});
	}
});




// 수정 전 코드

// const toggleBtn = document.querySelector('.navbar__toggleBtn');
// const menu = document.querySelector('.navbar__menu');
// const signin = document.querySelector('.header_signin');
// const toggleBtn1 = document.querySelector('.navbar__toggleBtn1');
// const logo = document.querySelector('.logo_txt');
// const search = document.querySelector('.header_search');

// toggleBtn.addEventListener('click', () => {
//   menu.classList.toggle('active')
//   signin.classList.toggle('active')
// })

// toggleBtn1.addEventListener('click', () => {
//   logo.classList.toggle('active')
//   search.classList.toggle('active')
// })