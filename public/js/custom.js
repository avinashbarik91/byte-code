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