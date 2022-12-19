/* OPENS/CLOSE MENU */
$(document).ready(function(){
	// Menu click
	$('.hamburguer').click(function(){
		$(this).find('.wrapper').toggleClass('open');
        $('.navHeader .links').slideToggle();
	});

	// Link click
	$('.navHeader .links ul li a').click(function(){
		$('.hamburguer .wrapper').toggleClass('open');
        $('.navHeader .links').slideToggle();
	});
});