$(function ()
{
	MutationObserver = window.MutationObserver || window.WebKitMutationObserver;

	var observer = new MutationObserver(function(mutations, observer) {
		var cnip = $("#calnotes-info-pane");
		$("#calnotes-filter-pane").width(window.innerWidth - parseInt(cnip.width()) - parseInt(cnip.css("right")));
	});
	
	observer.observe(document.getElementById("calnotes-info-pane"), { attributes : true, childList : false, subtree: false });
	
	$(".calnotes-difficulty-slider").each(function ()
	{
		var bg = $(this).css("background");
		$(this).slider({
				min: 1,
				max: 20,
				step: 1
		}).css("background", bg);
	});
	
	var cnip = $("#calnotes-info-pane");
	$("#calnotes-filter-pane").width(window.innerWidth - parseInt(cnip.width()));
	$(".hidepane").click(function ()
	{
		var direction = $(this).attr("direction");
		if (direction == "up")
		{
			var $lefty = $(this).parent();
			$lefty.animate({
		  		top: parseInt($lefty.css('top'), 10) == 0 ? -$lefty.height() - 4 : 0
   			}, 500);
		}
		else if (direction == "right")
		{
			var $lefty = $(this).parent();
			$lefty.animate({
		  		right: parseInt($lefty.css('right'), 10) == 0 ? -$lefty.width() - 4 : 0
   			}, 500);
		}
	});
});

$(window).resize(function ()
{
	var cnip = $("#calnotes-info-pane");
	$("#calnotes-filter-pane").width(window.innerWidth - parseInt(cnip.width()));
});