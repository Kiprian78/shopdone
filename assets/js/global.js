(function ($) {
	"use strict";

	var windowOn = $(window);
	windowOn.on('load', function () {
		$("#loading").fadeOut(500);
	});

	if ($('.w-header-height').length > 0) {
		var headerHeight = document.querySelector(".w-header-height");      
		var setHeaderHeight = headerHeight.offsetHeight;	
		
		$(".w-header-height").each(function () {
			$(this).css({
				'height' : setHeaderHeight + 'px'
			});
		});
	  }

	////////////////////////////////////////////////////
	// 02. Mobile Menu Js
	$('#mobile-menu').meanmenu({
		meanMenuContainer: '.mobile-menu',
		meanScreenWidth: "991",
		meanExpand: ['<i class="fa-regular fa-angle-right"></i>'],
	});

	$('#mobile-menu-lg').meanmenu({
		meanMenuContainer: '.mobile-menu-lg',
		meanScreenWidth: "1199",
		meanExpand: ['<i class="fa-regular fa-angle-right"></i>'],
	});

	////////////////////////////////////////////////////
	// 03. Common Js

	$("[data-background").each(function () {
		$(this).css("background-image", "url( " + $(this).attr("data-background") + "  )");
	});

	$("[data-width]").each(function () {
		$(this).css("width", $(this).attr("data-width"));
	});

	$("[data-bg-color]").each(function () {
		$(this).css("background-color", $(this).attr("data-bg-color"));
	});

	$("[data-text-color]").each(function () {
		$(this).css("color", $(this).attr("data-text-color"));
	});

	$(".has-img").each(function () {
		var imgSrc = $(this).attr("data-menu-img");
		var img = `<img class="mega-menu-img" src="${imgSrc}" alt="img">`;
		$(this).append(img);

	});


	$('.wp-menu nav > ul > li').slice(-4).addClass('menu-last');

	$('.w-header-side-menu > nav > ul > li a, .offcanvas__category > nav > ul > li a').each(function(i, v) {
		$(v).contents().eq(2).wrap('<span class="menu-text"/>');
	});


	if($('.main-menu.menu-style-3 > nav > ul').length > 0){
		$('.main-menu.menu-style-3 > nav > ul').append(`<li id="marker" class="w-menu-line"></li>`);
	}

	if ($("#w-offcanvas-lang-toggle").length > 0) {
		window.addEventListener('click', function(e){
		
			if (document.getElementById('w-offcanvas-lang-toggle').contains(e.target)){
				$(".w-lang-list").toggleClass("w-lang-list-open");
			}
			else{
				$(".w-lang-list").removeClass("w-lang-list-open");
			}
		});
	}

	if ($("#w-offcanvas-currency-toggle").length > 0) {
		window.addEventListener('click', function(e){
		
			if (document.getElementById('w-offcanvas-currency-toggle').contains(e.target)){
				$(".w-currency-list").toggleClass("w-currency-list-open");
			}
			else{
				$(".w-currency-list").removeClass("w-currency-list-open");
			}
		});
	}

	if ($("#w-header-setting-toggle").length > 0) {
		window.addEventListener('click', function(e){
	
			if (document.getElementById('w-header-setting-toggle').contains(e.target)){
				$(".w-header-setting ul").toggleClass("w-setting-list-open");
			}
			else{
				$(".w-header-setting ul").removeClass("w-setting-list-open");
			}
		});
	}

	if($('#password-show-toggle').length > 0){
		var btn = document.getElementById('password-show-toggle');
		
		btn.addEventListener('click', function(e){
			
			var inputType = document.getElementById('parola');
			var openEye = document.getElementById('open-eye');
			var closeEye = document.getElementById('close-eye');
	
			if (inputType.type === "password") {
				inputType.type = "text";
				openEye.style.display = 'block';
				closeEye.style.display = 'none';
			 } else {
				inputType.type = "password";
				openEye.style.display = 'none';
				closeEye.style.display = 'block';
			 }
		});
	}



	$('.w-hamburger-toggle').on('click', function(){
		$('.w-header-side-menu').slideToggle('w-header-side-menu');
	});


	////////////////////////////////////////////////////
	// 04. Menu Controls JS
	if($('.w-category-menu-content').length && $('.w-category-mobile-menu').length){
		let navContent = document.querySelector(".w-category-menu-content").outerHTML;
		let mobileNavContainer = document.querySelector(".w-category-mobile-menu");
		mobileNavContainer.innerHTML = navContent;
	
		$('.w-offcanvas-category-toggle').on('click', function(){
			$(this).siblings().find('nav').slideToggle();
		});
		
	
		let arrow = $(".w-category-mobile-menu .has-dropdown > a");
	
		arrow.each(function () {
			let self = $(this);
			let arrowBtn = document.createElement("BUTTON");
			arrowBtn.classList.add("dropdown-toggle-btn");
			arrowBtn.innerHTML = "<i class='fa-regular fa-angle-right'></i>";
	
			self.append(function () {
			  return arrowBtn;
			});
	
			self.find("button").on("click", function (e) {
			  e.preventDefault();
			  let self = $(this);
			  self.toggleClass("dropdown-opened");
			  self.parent().toggleClass("expanded");
			  self.parent().parent().addClass("dropdown-opened").siblings().removeClass("dropdown-opened");
			  self.parent().parent().children(".w-submenu").slideToggle();
			  
	
			});
	
		  });
	}

	if($('.w-main-menu-content').length && $('.w-main-menu-mobile').length){
		let navContent = document.querySelector(".w-main-menu-content").outerHTML;
		let mobileNavContainer = document.querySelector(".w-main-menu-mobile");
		mobileNavContainer.innerHTML = navContent;
	
	
		let arrow = $(".w-main-menu-mobile .has-dropdown > a");
	
		arrow.each(function () {
			let self = $(this);
			let arrowBtn = document.createElement("BUTTON");
			arrowBtn.classList.add("dropdown-toggle-btn");
			arrowBtn.innerHTML = "<i class='fa-regular fa-angle-right'></i>";
	
			self.append(function () {
			  return arrowBtn;
			});
	
			self.find("button").on("click", function (e) {
			  e.preventDefault();
			  let self = $(this);
			  self.toggleClass("dropdown-opened");
			  self.parent().toggleClass("expanded");
			  self.parent().parent().addClass("dropdown-opened").siblings().removeClass("dropdown-opened");
			  self.parent().parent().children(".w-submenu").slideToggle();
			  
	
			});
	
		  });
	}

	$(".w-category-menu-toggle").on("click", function () {
		$(".w-category-menu > nav > ul").slideToggle();
	});



	////////////////////////////////////////////////////
	// 05. Offcanvas Js
	$(".w-offcanvas-open-btn").on("click", function () {
		$(".offcanvas__area").addClass("offcanvas-opened");
		$(".body-overlay").addClass("opened");
	});
	$(".offcanvas-close-btn").on("click", function () {
		$(".offcanvas__area").removeClass("offcanvas-opened");
		$(".body-overlay").removeClass("opened");
	});

	////////////////////////////////////////////////////
	$(".w-search-open-btn").on("click", function () {
		$(".w-search-area").addClass("opened");
		$(".body-overlay").addClass("opened");
	});
	$(".w-search-close-btn").on("click", function () {
		$(".w-search-area").removeClass("opened");
		$(".body-overlay").removeClass("opened");
	});

	////////////////////////////////////////////////////
	$(".cartmini-open-btn").on("click", function () {
		$(".cartmini__area").addClass("cartmini-opened");
		$(".body-overlay").addClass("opened");
	});


	$(".cartmini-close-btn").on("click", function () {
		$(".cartmini__area").removeClass("cartmini-opened");
		$(".body-overlay").removeClass("opened");
	});

	////////////////////////////////////////////////////
	$(".filter-open-btn").on("click", function () {
		$(".w-filter-offcanvas-area").addClass("offcanvas-opened");
		$(".body-overlay").addClass("opened");
	});


	$(".filter-close-btn").on("click", function () {
		$(".w-filter-offcanvas-area").removeClass("offcanvas-opened");
		$(".body-overlay").removeClass("opened");
	});

	$(".filter-open-dropdown-btn").on("click", function () {
		$(".w-filter-dropdown-area").toggleClass('filter-dropdown-opened');
	});


	////////////////////////////////////////////////////
	$(".body-overlay").on("click", function () {
		$(".offcanvas__area").removeClass("offcanvas-opened");
		$(".w-search-area").removeClass("opened");
		$(".cartmini__area").removeClass("cartmini-opened");
		$(".w-filter-offcanvas-area").removeClass("offcanvas-opened");
		$(".body-overlay").removeClass("opened");
	});


	////////////////////////////////////////////////////
	// Sticky Header Js
	windowOn.on('scroll', function () {
		var scroll = $(window).scrollTop();
		if (scroll < 100) {
			$("#header-sticky").removeClass("header-sticky");
			$("#header-sticky-2").removeClass("header-sticky-2");
		} else {
			$("#header-sticky").addClass("header-sticky");
			$("#header-sticky-2").addClass("header-sticky-2");
		}
	});

	windowOn.on('scroll', function () {
		var scroll = $(window).scrollTop();
		if (scroll < 100) {
			$(".w-side-menu-5").removeClass("sticky-active");
		} else {
			$(".w-side-menu-5").addClass("sticky-active");
		}
	});

	// Nice Select Js
	$('.w-header-search-category select, .w-shop-area select, .w-checkout-area select, .profile__area select').niceSelect();

	function smoothSctoll() {
		$('.smooth a').on('click', function (event) {
			var target = $(this.getAttribute('href'));
			if (target.length) {
				event.preventDefault();
				$('html, body').stop().animate({
					scrollTop: target.offset().top - 120
				}, 1500);
			}
		});
	}
	smoothSctoll();

	function back_to_top() {
		var btn = $('#back_to_top');
		var btn_wrapper = $('.back-to-top-wrapper');

		windowOn.scroll(function () {
			if (windowOn.scrollTop() > 300) {
				btn_wrapper.addClass('back-to-top-btn-show');
			} else {
				btn_wrapper.removeClass('back-to-top-btn-show');
			}
		});

		btn.on('click', function (e) {
			e.preventDefault();
			$('html, body').animate({ scrollTop: 0 }, '300');
		});
	}
	back_to_top();

	var tp_rtl = localStorage.getItem('tp_dir');
	let rtl_setting = tp_rtl == 'rtl' ? true : false;


	// Slider Activation Area Start
	$('.w-slider-active-4').slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: true,
		fade: true,
		rtl: rtl_setting,
		centerMode: true,
		prevArrow: `<button type="button" class="w-slider-3-button-prev"><svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
		   <path d="M1.00073 6.99989L15 6.99989" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
		   <path d="M6.64648 1.5L1.00011 6.99954L6.64648 12.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></button>`,
		nextArrow: `<button type="button" class="w-slider-3-button-next"><svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path d="M14.9993 6.99989L1 6.99989" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
		<path d="M9.35352 1.5L14.9999 6.99954L9.35352 12.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
		</svg></button>`,
		asNavFor: '.w-slider-nav-active',
		appendArrows: $('.w-slider-arrow-4'),
		
	});

	$('.w-slider-nav-active').slick({
		infinite: true,
		slidesToShow: 3,
		slidesToScroll: 1,
		vertical: true,
		asNavFor: '.w-slider-active-4',
		dots: false,
		arrows: false,
		prevArrow: '<button type="button" class="w-slick-prev"><i class="fa-solid fa-arrow-up"></i></button>',
		nextArrow: '<button type="button" class="w-slick-next"><i class="fa-solid fa-arrow-down"></i></button>',
		centerMode: false,
		focusOnSelect: true,
		rtl: false,
	});


	// Main Slider
	var mainSlider = new Swiper('.w-slider-active', {
		slidesPerView: 1,
		spaceBetween: 30,
		loop: true,
		autoplay: {
			delay: 5000,
			disableOnInteraction: false,
			pauseOnMouseEnter: true,
	  },
		effect : 'fade',
		navigation: {
			nextEl: ".w-slider-button-next",
			prevEl: ".w-slider-button-prev",
		},
		pagination: {
			el: ".w-slider-dot",
			clickable: true,
			renderBullet: function (index, className) {
				return '<span class="' + className + '">' + '<button>' + (index + 1) + '</button>' + "</span>";
			},
		},
	});

	mainSlider.on('slideChangeTransitionStart', function (realIndex) {
        if ($('.swiper-slide.swiper-slide-active, .w-slider-item .is-light').hasClass('is-light')) {
            $('.w-slider-variation').addClass('is-light');
        } else {
            $('.w-slider-variation').removeClass('is-light');
        }
  });


	var slider = new Swiper('.shop-mega-menu-slider-active', {
		slidesPerView: 3,
		spaceBetween: 20,
		loop: true,
		rtl: rtl_setting,
		// Navigation arrows
		navigation: {
			nextEl: ".w-shop-mega-menu-button-next",
			prevEl: ".w-shop-mega-menu-button-prev",
		},
		pagination: {
			el: ".w-shop-mega-menu-dot",
			clickable: true,
			renderBullet: function (index, className) {
				return '<span class="' + className + '">' + '<button>' + (index + 1) + '</button>' + "</span>";
			},
		},
	});

	var slider = new Swiper('.w-blog-main-slider-active', {
		slidesPerView: 3,
		spaceBetween: 20,
		loop: true,
		autoplay: {
			delay: 4000,
		  },
		rtl: rtl_setting,
		// Navigation arrows
		navigation: {
			nextEl: ".w-blog-main-slider-button-next",
			prevEl: ".w-blog-main-slider-button-prev",
		},
		pagination: {
			el: ".w-blog-main-slider-dot",
			clickable: true,
			renderBullet: function (index, className) {
				return '<span class="' + className + '">' + '<button>' + (index + 1) + '</button>' + "</span>";
			},
		},
		breakpoints: {
			'1200': {
				slidesPerView: 3,
			},
			'992': {
				slidesPerView: 2,
			},
			'768': {
				slidesPerView: 2,
			},
			'576': {
				slidesPerView: 1,
			},
			'0': {
				slidesPerView: 1,
			},
		},
	});

	var mainSliderThumb4 = new Swiper ('.w-slider-nav-actives', {
		slidesPerView: 3,
		spaceBetween: 20,
		loop: true,
		direction: 'vertical',
	});

	// home 3 beauti
	var mainSlider4 = new Swiper('.w-slider-active-4s', {
		slidesPerView: 1,
		spaceBetween: 30,
		loop: true,
		rtl: rtl_setting,
		effect: 'fade',
		// Navigation arrows
		navigation: {
			nextEl: ".w-slider-3-button-next",
			prevEl: ".w-slider-3-button-prev",
		},
		pagination: {
			el: ".w-slider-3-dot",
			clickable: true,
			renderBullet: function (index, className) {
				return '<span class="' + className + '">' + '<button>' + (index + 1) + '</button>' + "</span>";
			},
		},
	});

	var slider = new Swiper('.w-product-offer-slider-active', {
		slidesPerView: 4,
		spaceBetween: 30,
		loop: true,
		rtl: rtl_setting,
		pagination: {
			el: ".w-deals-slider-dot",
			clickable: true,
			renderBullet: function (index, className) {
				return '<span class="' + className + '">' + '<button>' + (index + 1) + '</button>' + "</span>";
			},
		},
		breakpoints: {
			'1200': {
				slidesPerView: 3,
			},
			'992': {
				slidesPerView: 2,
			},
			'768': {
				slidesPerView: 2,
			},
			'576': {
				slidesPerView: 1,
			},
			'0': {
				slidesPerView: 1,
			},
		},
	});

	var slider = new Swiper('.w-product-arrival-active', {
		slidesPerView: 4,
		spaceBetween: 30,
		loop: true,
		rtl: rtl_setting,
		pagination: {
			el: ".w-arrival-slider-dot",
			clickable: true,
			renderBullet: function (index, className) {
				return '<span class="' + className + '">' + '<button>' + (index + 1) + '</button>' + "</span>";
			},
		},
		// Navigation arrows
		navigation: {
			nextEl: ".w-arrival-slider-button-next",
			prevEl: ".w-arrival-slider-button-prev",
		},
		breakpoints: {
			'1200': {
				slidesPerView: 4,
			},
			'992': {
				slidesPerView: 3,
			},
			'768': {
				slidesPerView: 2,
			},
			'576': {
				slidesPerView: 2,
			},
			'0': {
				slidesPerView: 1,
			},
		},
	});

	var slider = new Swiper('.w-product-banner-slider-active', {
		slidesPerView: 1,
		spaceBetween: 0,
		loop: true,
		effect: 'fade',
		pagination: {
			el: ".w-product-banner-slider-dot",
			clickable: true,
			renderBullet: function (index, className) {
				return '<span class="' + className + '">' + '<button>' + (index + 1) + '</button>' + "</span>";
			},
		},

	});

	var slider = new Swiper('.w-product-gadget-banner-slider-active', {
		slidesPerView: 1,
		spaceBetween: 0,
		loop: true,
		effect: 'fade',
		pagination: {
			el: ".w-product-gadget-banner-slider-dot",
			clickable: true,
			renderBullet: function (index, className) {
				return '<span class="' + className + '">' + '<button>' + (index + 1) + '</button>' + "</span>";
			},
		},

	});

	var slider = new Swiper('.w-category-slider-active-2', {
		slidesPerView: 5,
		spaceBetween: 20,
		loop: false,
		rtl: rtl_setting,
		enteredSlides: false,
		pagination: {
			el: ".w-category-slider-dot",
			clickable: true,
			renderBullet: function (index, className) {
				return '<span class="' + className + '">' + '<button>' + (index + 1) + '</button>' + "</span>";
			},
		},
		// Navigation arrows
		navigation: {
			nextEl: ".w-category-slider-button-next",
			prevEl: ".w-category-slider-button-prev",
		},
		scrollbar: {
			el: '.swiper-scrollbar',
			draggable: true,
			dragClass: 'w-swiper-scrollbar-drag',
			snapOnRelease: true,
		  },
		breakpoints: {
			'1200': {
				slidesPerView: 5,
			},
			'992': {
				slidesPerView: 4,
			},
			'768': {
				slidesPerView: 3,
			},
			'576': {
				slidesPerView: 2,
			},
			'0': {
				slidesPerView: 1,
			},
		},
	});

	var slider = new Swiper('.w-featured-slider-active', {
		slidesPerView: 3,
		spaceBetween: 10,
		loop: true,
		rtl: rtl_setting,
		enteredSlides: false,
		pagination: {
			el: ".w-featured-slider-dot",
			clickable: true,
			renderBullet: function (index, className) {
				return '<span class="' + className + '">' + '<button>' + (index + 1) + '</button>' + "</span>";
			},
		},
		// Navigation arrows
		navigation: {
			nextEl: ".w-featured-slider-button-next",
			prevEl: ".w-featured-slider-button-prev",
		},

		breakpoints: {
			'1200': {
				slidesPerView: 3,
			},
			'992': {
				slidesPerView: 3,
			},
			'768': {
				slidesPerView: 2,
			},
			'576': {
				slidesPerView: 1,
			},
			'0': {
				slidesPerView: 1,
			},
		},
	});

	var slider = new Swiper('.w-product-related-slider-active', {
		slidesPerView: 4,
		spaceBetween: 24,
		loop: true,
		rtl: rtl_setting,
		enteredSlides: false,
		pagination: {
			el: ".w-related-slider-dot",
			clickable: true,
			renderBullet: function (index, className) {
				return '<span class="' + className + '">' + '<button>' + (index + 1) + '</button>' + "</span>";
			},
		},
		// Navigation arrows
		navigation: {
			nextEl: ".w-related-slider-button-next",
			prevEl: ".w-related-slider-button-prev",
		},

		scrollbar: {
			el: '.w-related-swiper-scrollbar',
			draggable: true,
			dragClass: 'w-swiper-scrollbar-drag',
			snapOnRelease: true,
		  },

		breakpoints: {
			'1200': {
				slidesPerView: 4,
			},
			'992': {
				slidesPerView: 3,
			},
			'768': {
				slidesPerView: 2,
			},
			'576': {
				slidesPerView: 2,
			},
			'0': {
				slidesPerView: 1,
			},
		},
	});

	var slider = new Swiper('.w-testimoinal-slider-active-3', {
		slidesPerView: 2,
		spaceBetween: 24,
		loop: true,
		rtl: rtl_setting,
		enteredSlides: false,
		pagination: {
			el: ".w-testimoinal-slider-dot-3",
			clickable: true,
			renderBullet: function (index, className) {
				return '<span class="' + className + '">' + '<button>' + (index + 1) + '</button>' + "</span>";
			},
		},
		// Navigation arrows
		navigation: {
			nextEl: ".w-testimoinal-slider-button-next-3",
			prevEl: ".w-testimoinal-slider-button-prev-3",
		},

		breakpoints: {
			'1200': {
				slidesPerView: 2,
			},
			'992': {
				slidesPerView: 2,
			},
			'768': {
				slidesPerView: 1,
			},
			'576': {
				slidesPerView: 1,
			},
			'0': {
				slidesPerView: 1,
			},
		},
	});

	var slider = new Swiper('.w-category-slider-active-4', {
		slidesPerView: 5,
		spaceBetween: 25,
		loop: true,
		rtl: rtl_setting,
		enteredSlides: false,
		pagination: {
			el: ".w-category-slider-dot-4",
			clickable: true,
			renderBullet: function (index, className) {
				return '<span class="' + className + '">' + '<button>' + (index + 1) + '</button>' + "</span>";
			},
		},
		// Navigation arrows
		navigation: {
			nextEl: ".w-category-slider-button-next-4",
			prevEl: ".w-category-slider-button-prev-4",
		},

		scrollbar: {
			el: '.w-category-swiper-scrollbar',
			draggable: true,
			dragClass: 'w-swiper-scrollbar-drag',
			snapOnRelease: true,
		  },

		breakpoints: {
			'1400': {
				slidesPerView: 5,
			},
			'1200': {
				slidesPerView: 4,
			},
			'992': {
				slidesPerView: 3,
			},
			'768': {
				slidesPerView: 2,
			},
			'576': {
				slidesPerView: 2,
			},
			'0': {
				slidesPerView: 1,
			},
		},
	});

	var slider = new Swiper('.w-category-slider-active-5', {
		slidesPerView: 6,
		spaceBetween: 12,
		loop: true,
		rtl: rtl_setting,
		enteredSlides: false,
		pagination: {
			el: ".w-category-slider-dot-4",
			clickable: true,
			renderBullet: function (index, className) {
				return '<span class="' + className + '">' + '<button>' + (index + 1) + '</button>' + "</span>";
			},
		},
		// Navigation arrows
		navigation: {
			nextEl: ".w-category-slider-button-next-5",
			prevEl: ".w-category-slider-button-prev-5",
		},

		scrollbar: {
			el: '.w-category-5-swiper-scrollbar',
			draggable: true,
			dragClass: 'w-swiper-scrollbar-drag',
			snapOnRelease: true,
		  },

		breakpoints: {
			'1400': {
				slidesPerView: 6,
			},
			'1200': {
				slidesPerView: 5,
			},
			'992': {
				slidesPerView: 4,
			},
			'768': {
				slidesPerView: 3,
			},
			'576': {
				slidesPerView: 2,
			},
			'400': {
				slidesPerView: 2,
			},
			'0': {
				slidesPerView: 1,
			},
		},
	});

	var slider = new Swiper('.w-brand-slider-active', {
		slidesPerView: 5,
		spaceBetween: 0,
		loop: true,
		rtl: rtl_setting,
		enteredSlides: false,
		pagination: {
			el: ".w-brand-slider-dot",
			clickable: true,
			renderBullet: function (index, className) {
				return '<span class="' + className + '">' + '<button>' + (index + 1) + '</button>' + "</span>";
			},
		},
		// Navigation arrows
		navigation: {
			nextEl: ".w-brand-slider-button-next",
			prevEl: ".w-brand-slider-button-prev",
		},

		breakpoints: {
			'1200': {
				slidesPerView: 5,
			},
			'992': {
				slidesPerView: 5,
			},
			'768': {
				slidesPerView: 4,
			},
			'576': {
				slidesPerView: 3,
			},
			'0': {
				slidesPerView: 1,
			},
		},
	});

	var slider = new Swiper('.w-best-slider-active', {
		slidesPerView: 4,
		spaceBetween: 24,
		loop: true,
		rtl: rtl_setting,
		enteredSlides: false,
		pagination: {
			el: ".w-best-slider-dot",
			clickable: true,
			renderBullet: function (index, className) {
				return '<span class="' + className + '">' + '<button>' + (index + 1) + '</button>' + "</span>";
			},
		},
		// Navigation arrows
		navigation: {
			nextEl: ".w-best-slider-button-next",
			prevEl: ".w-best-slider-button-prev",
		},

		scrollbar: {
			el: '.w-best-swiper-scrollbar',
			draggable: true,
			dragClass: 'w-swiper-scrollbar-drag',
			snapOnRelease: true,
		  },

		breakpoints: {
			'1200': {
				slidesPerView: 4,
			},
			'992': {
				slidesPerView: 4,
			},
			'768': {
				slidesPerView: 2,
			},
			'576': {
				slidesPerView: 2,
			},
			'0': {
				slidesPerView: 1,
			},
		},
	});

	var slider = new Swiper('.w-best-slider-active-5', {
		slidesPerView: 3,
		spaceBetween: 24,
		loop: true,
		rtl: rtl_setting,
		enteredSlides: false,
		pagination: {
			el: ".w-best-slider-dot-5",
			clickable: true,
			renderBullet: function (index, className) {
				return '<span class="' + className + '">' + '<button>' + (index + 1) + '</button>' + "</span>";
			},
		},
		// Navigation arrows
		navigation: {
			nextEl: ".w-best-slider-5-button-next",
			prevEl: ".w-best-slider-5-button-prev",
		},

		scrollbar: {
			el: '.w-best-5-swiper-scrollbar',
			draggable: true,
			dragClass: 'w-swiper-scrollbar-drag',
			snapOnRelease: true,
		  },

		breakpoints: {
			'1200': {
				slidesPerView: 3,
			},
			'992': {
				slidesPerView: 2,
			},
			'768': {
				slidesPerView: 2,
			},
			'576': {
				slidesPerView: 2,
			},
			'0': {
				slidesPerView: 1,
			},
		},
	});

	var slider = new Swiper('.w-product-details-thumb-slider-active', {
		slidesPerView: 2,
		spaceBetween: 13,
		loop: true,
		rtl: rtl_setting,
		enteredSlides: false,
		pagination: {
			el: ".w-product-details-thumb-slider-dot",
			clickable: true,
			renderBullet: function (index, className) {
				return '<span class="' + className + '">' + '<button>' + (index + 1) + '</button>' + "</span>";
			},
		},
		// Navigation arrows
		navigation: {
			nextEl: ".w-product-details-thumb-slider-5-button-next",
			prevEl: ".w-product-details-thumb-slider-5-button-prev",
		},


		breakpoints: {
			'1200': {
				slidesPerView: 2,
			},
			'992': {
				slidesPerView: 2,
			},
			'768': {
				slidesPerView: 2,
			},
			'576': {
				slidesPerView: 2,
			},
			'0': {
				slidesPerView: 1,
			},
		},
	});

	var slider = new Swiper('.w-trending-slider-active', {
		slidesPerView: 2,
		spaceBetween: 24,
		loop: true,
		rtl: rtl_setting,
		enteredSlides: false,
		pagination: {
			el: ".w-trending-slider-dot",
			clickable: true,
			renderBullet: function (index, className) {
				return '<span class="' + className + '">' + '<button>' + (index + 1) + '</button>' + "</span>";
			},
		},
		// Navigation arrows
		navigation: {
			nextEl: ".w-trending-slider-button-next",
			prevEl: ".w-trending-slider-button-prev",
		},

		breakpoints: {
			'1200': {
				slidesPerView: 2,
			},
			'992': {
				slidesPerView: 2,
			},
			'768': {
				slidesPerView: 2,
			},
			'576': {
				slidesPerView: 2,
			},
			'0': {
				slidesPerView: 1,
			},
		},
	});

	var specialSlider = new Swiper('.w-special-slider-active', {
		slidesPerView: 1,
		spaceBetween: 0,
		loop: true,
		rtl: rtl_setting,
		effect: 'fade',
		enteredSlides: false,
		pagination: {
			el: ".w-special-slider-dot",
			clickable: true,
			renderBullet: function (index, className) {
				return '<span class="' + className + '">' + '<button>' + (index + 1) + '</button>' + "</span>";
			},
		},
		// Navigation arrows
		navigation: {
			nextEl: ".w-special-slider-button-next",
			prevEl: ".w-special-slider-button-prev",
		},
	});

	var slider = new Swiper('.w-testimonial-slider-active', {
		slidesPerView: 1,
		spaceBetween: 0,
		loop: true,
		rtl: rtl_setting,
		pagination: {
			el: ".w-testimonial-slider-dot",
			clickable: true,
			renderBullet: function (index, className) {
				return '<span class="' + className + '">' + '<button>' + (index + 1) + '</button>' + "</span>";
			},
		},
		// Navigation arrows
		navigation: {
			nextEl: ".w-testimonial-slider-button-next",
			prevEl: ".w-testimonial-slider-button-prev",
		},
	});

	var slider = new Swiper('.w-testimonial-slider-active-5', {
		slidesPerView: 1,
		spaceBetween: 0,
		loop: true,
		rtl: rtl_setting,
		enteredSlides: false,
		pagination: {
			el: ".w-testimonial-slider-dot-5",
			clickable: true,
			renderBullet: function (index, className) {
				return '<span class="' + className + '">' + '<button>' + (index + 1) + '</button>' + "</span>";
			},
		},
		// Navigation arrows
		navigation: {
			nextEl: ".w-testimonial-slider-5-button-next",
			prevEl: ".w-testimonial-slider-5-button-prev",
		},
		
	});

	var slider = new Swiper('.w-best-banner-slider-active-5', {
		slidesPerView: 1,
		spaceBetween: 0,
		loop: true,
		rtl: rtl_setting,
		enteredSlides: false,
		effect : 'fade',
		pagination: {
			el: ".w-best-banner-slider-dot-5",
			clickable: true,
			renderBullet: function (index, className) {
				return '<span class="' + className + '">' + '<button>' + (index + 1) + '</button>' + "</span>";
			},
		},
		// Navigation arrows
		navigation: {
			nextEl: ".w-best-banner-slider-5-button-next",
			prevEl: ".w-best-banner-slider-5-button-prev",
		},
	});

	var postboxSlider = new Swiper('.w-postbox-slider', {
		slidesPerView: 1,
		spaceBetween: 0,
		loop: true,
		rtl: rtl_setting,
		autoplay: {
			delay: 3000,
		},
		// Navigation arrows
		navigation: {
			nextEl: ".w-postbox-slider-button-next",
			prevEl: ".w-postbox-slider-button-prev",
		},
		breakpoints: {
			'1200': {
				slidesPerView: 1,
			},
			'992': {
				slidesPerView: 1,
			},
			'768': {
				slidesPerView: 1,
			},
			'576': {
				slidesPerView: 1,
			},
			'0': {
				slidesPerView: 1,
			},
		},
	});

	var historyNav = new Swiper(".w-history-nav-active", {
		spaceBetween: 220,
		slidesPerView: 4,
		watchSlidesProgress: true,
		breakpoints: {
			'1200': {
				spaceBetween: 220,
				slidesPerView: 4,
			},
			'992': {
				spaceBetween: 150,
				slidesPerView: 4,
			},
			'768': {
				spaceBetween: 100,
				slidesPerView: 4,
			},
			'576': {
				spaceBetween: 80,
				slidesPerView: 3,
			},
			'0': {
				slidesPerView: 2,
				spaceBetween: 50,
			},
		}
	  });
	  var historyMain = new Swiper(".w-history-slider-active", {
		spaceBetween: 0,
		effect : 'fade',
		navigation: {
		  nextEl: ".swiper-button-next",
		  prevEl: ".swiper-button-prev",
		},
		thumbs: {
		  swiper: historyNav,
		},
		
	  });


	////////////////////////////////////////////////////
	$('.grid').imagesLoaded(function () {
		// init Isotope
		var $grid = $('.grid').isotope({
			itemSelector: '.grid-item',
			percentPosition: true,
			masonry: {
				// use outer width of grid-sizer for columnWidth
				columnWidth: '.grid-item',
			}
		});


		// filter items on button click
		$('.masonary-menu').on('click', 'button', function () {
			var filterValue = $(this).attr('data-filter');
			$grid.isotope({ filter: filterValue });
		});

		//for menu active class
		$('.masonary-menu button').on('click', function (event) {
			$(this).siblings('.active').removeClass('active');
			$(this).addClass('active');
			event.preventDefault();
		});

	});

	/* magnificPopup img view */
	$('.popup-image').magnificPopup({
		type: 'image',
		gallery: {
			enabled: true
		}
	});

	/* magnificPopup video view */
	$(".popup-video").magnificPopup({
		type: "iframe",
	});


	if ($('.scene').length > 0) {
		$('.scene').parallax({
			scalarX: 5.0,
			scalarY: 5.0,
		});
	};

	// Wow Js
	new WOW().init();

	function tp_ecommerce() {
		$('.w-cart-minus').on('click', function () {
			var $input = $(this).parent().find('input');
			var count = parseInt($input.val()) - 1;
			count = count < 1 ? 1 : count;
			$input.val(count);
			$input.change();
			return false;
		});
	
		$('.w-cart-plus').on('click', function () {
			var $input = $(this).parent().find('input');
			$input.val(parseInt($input.val()) + 1);
			$input.change();
			return false;
		});

		$("#slider-range").slider({
			range: true,
			min: 0,
			max: 500,
			values: [75, 300],
			slide: function (event, ui) {
				$("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
			}
		});
		$("#amount").val("$" + $("#slider-range").slider("values", 0) +
			" - $" + $("#slider-range").slider("values", 1));

		$("#slider-range-offcanvas").slider({
			range: true,
			min: 0,
			max: 500,
			values: [75, 300],
			slide: function (event, ui) {
				$("#amount-offcanvas").val("$" + ui.values[0] + " - $" + ui.values[1]);
			}
		});
		$("#amount-offcanvas").val("$" + $("#slider-range-offcanvas").slider("values", 0) +
			" - $" + $("#slider-range-offcanvas").slider("values", 1));
	
		

		$('.w-checkout-payment-item label').on('click', function () {
			$(this).siblings('.w-checkout-payment-desc').slideToggle(400);
			
		});
		

		$('.w-color-variation-btn').on('click', function () {
			$(this).addClass('active').siblings().removeClass('active');
		});
		

		$('.w-size-variation-btn').on('click', function () {
			$(this).addClass('active').siblings().removeClass('active');
		});
		
	
		// Shipping Box Toggle Js
		$('#ship-box').on('click', function () {
			$('#ship-box-info').slideToggle(1000);
		});

		$("#slider-range").slider({
			range: true,
			min: 0,
			max: 500,
			values: [75, 300],
			slide: function (event, ui) {
			  $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
			},
		});
	}
	tp_ecommerce();

	
	
	// InHover Active Js
	$('.hover__active').on('mouseenter', function () {
		$(this).addClass('active').parent().siblings().find('.hover__active').removeClass('active');
	});

	$('.activebsba').on("click", function () {
		$('#services-item-thumb').removeClass().addClass($(this).attr('rel'));
		$(this).addClass('active').siblings().removeClass('active');
	});


	// Line Animation Js
	if ($('#marker').length > 0) {
		function tp_tab_line(){
			var marker = document.querySelector('#marker');
			var item = document.querySelectorAll('.menu-style-3  > nav > ul > li');
			var itemActive = document.querySelector('.menu-style-3  > nav > ul > li.active');

			function indicator(e){
				marker.style.left = e.offsetLeft+"px";
				marker.style.width = e.offsetWidth+"px";
			}
				
			item.forEach(link => {
				link.addEventListener('mouseenter', (e)=>{
					indicator(e.target);
				});
				
			});

			
			var activeNav = $('.menu-style-3 > nav > ul > li.active');
			var activewidth = $(activeNav).width();
			var activePadLeft = parseFloat($(activeNav).css('padding-left'));
			var activePadRight = parseFloat($(activeNav).css('padding-right'));
			var totalWidth = activewidth + activePadLeft + activePadRight;
			
			var precedingAnchorWidth = anchorWidthCounter();
		
		
			$(marker).css('display','block');
			
			$(marker).css('width', totalWidth);
		
			function anchorWidthCounter() {
				var anchorWidths = 0;
				var a;
				var aWidth;
				var aPadLeft;
				var aPadRight;
				var aTotalWidth;
				$('.menu-style-3 > nav > ul > li').each(function(index, elem) {
					var activeTest = $(elem).hasClass('active');
					marker.style.left = elem.offsetLeft+"px";
					if(activeTest) {
					// Break out of the each function.
					return false;
					}
			
					a = $(elem).find('li');
					aWidth = a.width();
					aPadLeft = parseFloat(a.css('padding-left'));
					aPadRight = parseFloat(a.css('padding-right'));
					aTotalWidth = aWidth + aPadLeft + aPadRight;
			
					anchorWidths = anchorWidths + aTotalWidth;
	
				});
		
				return anchorWidths;
			}
		}
		tp_tab_line();
	}


	if ($('#productTabMarker').length > 0) {
		function tp_tab_line_2(){
			var marker = document.querySelector('#productTabMarker');
			var item = document.querySelectorAll('.w-product-tab button');
			var itemActive = document.querySelector('.w-product-tab .nav-link.active');

			// rtl settings
			var tp_rtl = localStorage.getItem('tp_dir');
			let rtl_setting = tp_rtl == 'rtl' ? 'right' : 'left';

			function indicator(e){
				marker.style.left = e.offsetLeft+"px";
				marker.style.width = e.offsetWidth+"px";
			}
				
		
			item.forEach(link => {
				link.addEventListener('click', (e)=>{
					indicator(e.target);
				});
			});
			
			var activeNav = $('.nav-link.active');
			var activewidth = $(activeNav).width();
			var activePadLeft = parseFloat($(activeNav).css('padding-left'));
			var activePadRight = parseFloat($(activeNav).css('padding-right'));
			var totalWidth = activewidth + activePadLeft + activePadRight;
			
			var precedingAnchorWidth = anchorWidthCounter();
		
		
			$(marker).css('display','block');
			
			$(marker).css('width', totalWidth);
		
			function anchorWidthCounter() {
				var anchorWidths = 0;
				var a;
				var aWidth;
				var aPadLeft;
				var aPadRight;
				var aTotalWidth;
				$('.w-product-tab button').each(function(index, elem) {
					var activeTest = $(elem).hasClass('active');
					marker.style.left = elem.offsetLeft+"px";
					if(activeTest) {
					// Break out of the each function.
					return false;
					}
			
					a = $(elem).find('button');
					aWidth = a.width();
					aPadLeft = parseFloat(a.css('padding-left'));
					aPadRight = parseFloat(a.css('padding-right'));
					aTotalWidth = aWidth + aPadLeft + aPadRight;
			
					anchorWidths = anchorWidths + aTotalWidth;
	
				});
		
				return anchorWidths;
			}
		}
		tp_tab_line_2();
	}

	// Video Play Js
	var play = false;
	$('.w-video-toggle-btn').on('click', function(){

		if(play === false){
			$('.w-slider-video').addClass('full-width');
			$(this).addClass('hide');
			play = true;

			$('.w-slider-video').find('video').each(function() {
				$(this).get(0).play();
			});
		}else{
			$('.w-slider-video').removeClass('full-width');
			$(this).removeClass('hide');
			play = false;
			$('.w-slider-video').find('video').each(function() {
				$(this).get(0).pause();
			});
		}

	});
	
	// Password Toggle Js
	if($('#password-show-toggle').length > 0){
		var btn = document.getElementById('password-show-toggle');
		
		btn.addEventListener('click', function(e){
			
			var inputType = document.getElementById('tp_password');
			var openEye = document.getElementById('open-eye');
			var closeEye = document.getElementById('close-eye');
	
			if (inputType.type === "password") {
				inputType.type = "text";
				openEye.style.display = 'block';
				closeEye.style.display = 'none';
			 } else {
				inputType.type = "password";
				openEye.style.display = 'none';
				closeEye.style.display = 'block';
			 }
		});
	}

	if ($('.infinite-container').length > 0) {
		let ias = new InfiniteAjaxScroll('.infinite-container', {
			item: '.infinite-item',
			next: '.infinite-next-link',
			pagination: '.infinite-pagination'
		});

	}

})(jQuery);

const ContactForm = function(){
	var csrfToken = document.querySelector('meta[name="csrf-token"]').content;
	$("#ctToken").val(csrfToken);
	setTimeout(() => { 
			$("#btnSend").prop("disabled",false); } 
			,"5000");
}

const ReloadPage = function(){
	window.location.reload();
}

const AbonareNL = function(){
	var xEmail = $("#anl_email").val();
	$.post("./",{do:'AbonareNewsletter', anl_email:xEmail},function(data){
		$.magnificPopup.open({
			items: {
				src: '<div class="white-popup"><div class="container-fluid"><div class="row">'+data+'</div></div></div>',
				type: 'inline'
			}
		});
		setTimeout(ReloadPage,6000);   
	});
}

const AgreeCookies = function(){
  //var hName = window.location.hostname;
  //hName = "shop.ekkoo.ro";  
  hName = "shopdone.ekkoo.ro";  
  var expData = new Date();
  expData.setMonth(expData.getMonth() + 1);
  document.cookie = "AgreeCookies=Yes;expires="+expData+";domain="+hName+";path=/";
	ReloadPage();
}

const Add2Cos = function(xID){
	$.post("./",{do:'Add2Cos', pid:xID},function(data){
		$.magnificPopup.open({
			items: {
				src: '<div class="white-popup"><div class="container-fluid"><div class="row">'+data+'</div></div></div>',
				type: 'inline'
			}
		});
		setTimeout(ReloadPage,12000);     
	});
}

const RemoveFromCos = function(xCos){
	if(confirm('Sigur, doriti sa stergeti produsul?')){
		$.post("./",{do:'DeleteDinCos',cmid:xCos},function(data){		
			ReloadPage();
		});
	} else { ReloadPage(); }
}

const CosPlus = function(xCos){
	$.post("./",{do:'SetCosPlus',cmid:xCos},function(data){
		ReloadPage();
	});
}
const CosMinus = function(xCos){
	$.post("./",{do:'SetCosMinus',cmid:xCos},function(data){
		ReloadPage();
	});
}