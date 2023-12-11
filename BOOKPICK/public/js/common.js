function toggleMenuBtn() {
	let menu = document.querySelector('#menu-icon');
	let sidebar = document.querySelector('#sidebar');
	let btntoggle = document.querySelector('#btn-toggle');
    menu.addEventListener('click', () => {
		sidebar.classList.remove('show');
		btntoggle.setAttribute("aria-expanded", "false");
	})
};

