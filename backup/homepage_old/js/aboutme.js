$(document).ready(function(){
	$(".nav-icon").on("click",function(){
		$(".lSide-contact").animate({width:"toggle"},500);
	});

	$(".rSide-content h2").show().addClass("animated slideInLeft");
	$(".skill").show().addClass("animated slideInUp");
})