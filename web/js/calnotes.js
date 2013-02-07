$(function ()
{
	MutationObserver = window.MutationObserver || window.WebKitMutationObserver;

	var observer1 = new MutationObserver(function(mutations, observer) {
		var cnip = $("#calnotes-info-pane");
		$("#calnotes-filter-pane, #calnotes-viewport").width(window.innerWidth - parseInt(cnip.innerWidth()) - parseInt(cnip.css("right")));
	});
	
	var observer2 = new MutationObserver(function(mutations, observer) {
		var cnfp = $("#calnotes-filter-pane");
		$("#calnotes-viewport").height(window.innerHeight - parseInt(cnfp.innerHeight()) - parseInt(cnfp.css("top")));
	});
	
	$.getJSON('api/?cmd=get_colleges', function(data) 
	{
		var t;
		if (data['success'])
		{
			$("#calnotes-filter-pane-colleges").html("<option value='-1'>Any</option>");
			for (var i in data['colleges']) $("#calnotes-filter-pane-colleges").append("<option value='"+data["colleges"][i][0]+"'>"+data["colleges"][i][1]+"</option>");
		}
	});
	
	$("#calnotes-filter-pane-colleges").change(function(e)
	{
		if ($(this).val() != "-1")
		{
			$.getJSON('api/?cmd=get_majors&id='+$(this).val(), function (data)
			{
				$("#calnotes-filter-pane-majors").html("<option value='-1'>Any</option>");
			for (var i in data) $("#calnotes-filter-pane-majors").append("<option value='"+data[i][0]+"'>"+data[i][1]+"</option>").removeAttr("disabled");
			});
		}
		else
		{
			$("#calnotes-filter-pane-majors, #calnotes-filter-pane-classes").attr("disabled", "").html("<option value='-1'>--</option>");
		}
	});
	
	$("#calnotes-filter-pane-majors").change(function(e)
	{
		if ($(this).val() != "-1")
		{
			$.getJSON('api/?cmd=get_classes&id='+$(this).val(), function (data)
			{
				$("#calnotes-filter-pane-classes").html("<option value='-1'>Any</option>");
			for (var i in data) $("#calnotes-filter-pane-classes").append("<option value='"+data[i][0]+"'>"+data[i][1]+"</option>").removeAttr("disabled");
			});
		}
		else
		{
			$("#calnotes-filter-pane-classes").attr("disabled", "").html("<option value='-1'>--</option>");
		}
	});
	
	observer1.observe(document.getElementById("calnotes-info-pane"), { attributes : true, childList : false, subtree: false });
	observer2.observe(document.getElementById("calnotes-filter-pane"), { attributes : true, childList : false, subtree: false });
	
	$(".calnotes-difficulty-slider").each(function ()
	{
		var bg = $(this).css("background");
		$(this).slider({
				min: 1,
				max: 20,
				step: 1
		}).css("background", bg);
	});
	
	var cnip = $("#calnotes-info-pane"), cnfp = $("#calnotes-filter-pane");
	$("#calnotes-viewport").height(window.innerHeight - parseInt(cnfp.innerHeight()) - parseInt(cnfp.css("top")));
	$("#calnotes-filter-pane, #calnotes-viewport").width(window.innerWidth - parseInt(cnip.innerWidth()) - parseInt(cnip.css("right")));
	$(".hidepane").click(function ()
	{
		var direction = $(this).attr("direction");
		if (direction == "up")
		{
			var $lefty = $(this).parent();
			$lefty.animate({
		  		top: parseInt($lefty.css('top'), 10) == 0 ? -$lefty.innerHeight() - 4 : 0
   			}, 500);
		}
		else if (direction == "right")
		{
			var $lefty = $(this).parent();
			$lefty.animate({
		  		right: parseInt($lefty.css('right'), 10) == 0 ? -$lefty.innerWidth() - 4 : 0
   			}, 500);
		}
	});
});

$(window).resize(function ()
{
	var cnip = $("#calnotes-info-pane"), cnfp = $("#calnotes-filter-pane");
	$("#calnotes-viewport").height(window.innerHeight - parseInt(cnfp.height()) - parseInt(cnfp.css("top")));
	$("#calnotes-filter-pane, #calnotes-viewport").width(window.innerWidth - parseInt(cnip.innerWidth()) - parseInt(cnip.css("right")));
});