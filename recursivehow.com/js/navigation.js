$(document).ready(function() {
	var stickyNavTop = $('.navigationBar').offset().top;
	var stickyNav = function(){
		var home = document.getElementById('home');
		var scrollTop = $(window).scrollTop();
		var filler = document.createElement('div');
		filler.setAttribute("class", "navigationFiller");

		if (scrollTop > stickyNavTop) { 
			if(!home.hasChildNodes()){
				home.appendChild(filler);	
			}
			$('.navigationBar').addClass('sticky');
		} else {
			if(home.hasChildNodes()){
				home.removeChild(home.childNodes[0]);
			}
			$('.navigationBar').removeClass('sticky'); 
		}
	};

	stickyNav();

	$(window).scroll(function() {
		stickyNav();
	});
});
