const toggleBtn = document.querySelector('.navbar__toggleBtn');
const menu = document.querySelector('.navbar__menu');
const signin = document.querySelector('.header_signin');
const toggleBtn1 = document.querySelector('.navbar__toggleBtn1');
const logo = document.querySelector('.logo_txt');
const search = document.querySelector('.header_search');

toggleBtn.addEventListener('click', () => {
  menu.classList.toggle('active')
  signin.classList.toggle('active')
})

toggleBtn1.addEventListener('click', () => {
  logo.classList.toggle('active')
  search.classList.toggle('active')
})