const nav = document.querySelector(".nav");
const navBtn = document.querySelector(".burger-btn");
const navItems = document.querySelectorAll(".nav__item");
const navBtn1 = document.querySelector(".nav__btn1");
const navBtn2 = document.querySelector(".nav__btn2");
const navBtn3 = document.querySelector(".nav__btn3");
const navBtn4 = document.querySelector(".nav__btn4");
const navBtn5 = document.querySelector(".nav__btn5");
const navBtn6 = document.querySelector(".nav__btn6");
const navMenuBars = document.querySelector(".burger-btn__icon");
const navMenuCircle = document.querySelector(".burger-btn__circle");
const sections = document.querySelectorAll(".section");
// const navMenuBars = document.querySelector(".burger-btn__bars");

// nav menu show/hide
const handleNav = () => {
	nav.classList.toggle("nav--active");
	navBtn.classList.toggle("burger-btn--open");

	navItems.forEach((item) => {
		item.addEventListener("click", () => {
			nav.classList.remove("nav--active");
		});
	});
};

// navItems animation
const navItemsAnima = () => {
	let delayTime = 0;

	navItems.forEach((item) => {
		item.classList.toggle("nav-items-anima");
		// little delay with navItems
		item.style.animationDelay = "." + delayTime + "s";
		delayTime++;
	});
};

// del class after navItem click
const deleteUselessClass = () => {
	nav.classList.toggle("nav--active");
	navBtn.classList.toggle("burger-btn--open");
	navItemsAnima();
};

// navigo btn to black
const sectionsPositions = () => {
	const currentPosition = window.scrollY;

	sections.forEach(section => {
		if (section.classList.contains('white-section') && section.offsetTop <= currentPosition + 70) {
			navMenuBars.classList.add('black-nav-icon');
			navMenuCircle.classList.add('black-nav-circle');
			// remove dark when nav is open
			if (navBtn.classList.contains('burger-btn--open')) {
				navMenuBars.classList.remove('black-nav-icon');
				navMenuCircle.classList.remove('black-nav-circle');
			}
		} else if (!section.classList.contains('white-section') && section.offsetTop <= currentPosition + 70) {
			navMenuBars.classList.remove('black-nav-icon');
			navMenuCircle.classList.remove('black-nav-circle');
		}
	})
}

// moving burger-btn / jest tez w jquery
// const scrollBurgerBtn = () => {
// 	const navy = navBtn.offsetTop;
// 	const scrollY = window.pageYOffset;

// 	if (scrollY > navy)
// 	{
// 		navBtn.classList.add('sticky');
// 	} else {
// 		navBtn.classList.remove('sticky');
// 	}
// }

// weather-widget
!function(d,s,id){
	var js,fjs=d.getElementsByTagName(s)[0];
	if(!d.getElementById(id)){
		js=d.createElement(s);
		js.id=id;
		js.src='https://weatherwidget.io/js/widget.min.js';
		fjs.parentNode.insertBefore(js,fjs);
	}
}(document,'script','weatherwidget-io-js');


navBtn.addEventListener("click", handleNav);
navBtn.addEventListener("click", navItemsAnima);
navBtn1.addEventListener("click", deleteUselessClass);
navBtn2.addEventListener("click", deleteUselessClass);
navBtn3.addEventListener("click", deleteUselessClass);
navBtn4.addEventListener("click", deleteUselessClass);
navBtn5.addEventListener("click", deleteUselessClass);
navBtn6.addEventListener("click", deleteUselessClass);
// window.addEventListener('scroll', scrollBurgerBtn); // jest tez w jquery
window.addEventListener('scroll', sectionsPositions);