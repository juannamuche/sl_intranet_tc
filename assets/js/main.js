//$.noConflict();

jQuery(document).ready(function($) {

	"use strict";

	 [].slice.call(document.querySelectorAll('select.cs-select')).forEach(function(el) {
	 	new SelectFx(el);
	 });

	// $('.selectpicker').selectpicker();


	$('.search-trigger').on('click', function(event) {
		event.preventDefault();
		event.stopPropagation();
		$('.search-trigger').parent('.header-left').addClass('open');
	});

	$('.search-close').on('click', function(event) {
		event.preventDefault();
		event.stopPropagation();
		$('.search-trigger').parent('.header-left').removeClass('open');
	});

	// $('.equal-height').matchHeight({
	// 	property: 'max-height'
	// });

	$('.count').each(function() {
		$(this).prop('Counter', 0).animate({
			Counter: $(this).text()
		}, {
			duration: 3000,
			easing: 'swing',
			step: function(now) {
				$(this).text(Math.ceil(now));
			}
		});
	});


	$('#menuToggle').on('click', function(event) {
		var windowWidth = $(window).width();
		if (windowWidth < 1010) {
			$('body').removeClass('open');
			if (windowWidth < 760) {
				$('#left-panel').slideToggle();
			} else {
				$('#left-panel').toggleClass('open-menu');
			}
		} else {
			$('body').toggleClass('open');
			$('#left-panel').removeClass('open-menu');
		}
	});

	$(".menu-item-has-children.dropdown").each(function() {
		$(this).on('click', function() {
			if (!$(this).data('subtitleAdded')) {
				var $temp_text = $(this).children('.dropdown-toggle').html();
				$(this).children('.sub-menu').prepend('<li class="subtitle">' + $temp_text + '</li>');

				$(this).data('subtitleAdded', true);

				$(this).off('click');
			}
		});
	});

	 $(window).on("load resize", function(event) {
	 	var windowWidth = $(window).width();
	 	if (windowWidth < 1010) {
	 		$('body').addClass('small-device');
	 	} else {
	 		$('body').removeClass('small-device');
	 	}
	 });

});
