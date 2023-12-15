// 햄버거 메뉴
let isImage = true;
function toggleSidebar() {
    const sidebarSubMenu = document.querySelector('.sidebar_submenu');
    const sidebar = document.querySelector('.sidebar');
    const hamburgerMenu = document.querySelector('.hamburger_menu');
    sidebarSubMenu.classList.toggle('active');
    sidebar.classList.toggle('active');
    sidebar.classList.toggle('position_top');
	isImage = !isImage;
	if(isImage) {
		hamburgerMenu.src = "img/sidebar-hamburger.png"
	} else {
		hamburgerMenu.src = "img/sidebar-close.png"
	}
}