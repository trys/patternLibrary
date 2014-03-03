var theLibrary = ( function () {
	"use strict";
	return {
		init: function() {
			$('#nav-controls').on('click', theLibrary.toggleNavigation);
			$('.library-nav-list a').on('click', theLibrary.toggleNavigation );
		},
		toggleNavigation: function () {
			$('body').toggleClass('nav-open');
		}
	}

}());

document.addEventListener('DOMContentLoaded', function() {
	theLibrary.init();
});