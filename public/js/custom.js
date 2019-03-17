$(".expand-icon").click(function() {
	$(this).siblings(".job-description").slideDown();
	$(this).siblings(".contract-icon").show();
	$(this).hide();
});

$(".contract-icon").click(function() {
	$(this).siblings(".job-description").slideUp();
	$(this).siblings(".expand-icon").show();
	$(this).hide();
});

$(".navbar-nav a[href^='#']").on('click', function(e){	
	e.preventDefault();
	var hash = this.hash;

	$('html, body').animate({
       scrollTop: $(hash).offset().top
     }, 300);
});

$(document).ready(function(){
	setTimeout(function(){
		$(".lds-dual-ring").fadeOut();
		$(".content, .intro-bio-section, .footer, .navbar").fadeIn(500);
		$(".navbar-nav .home-link").addClass("active");		
	}, 500);
});

