var filterState = $(".filtros").css('display') != 'block' ? filtro = "hide" : filtro = "show";
var urlFilter   = $('#fGridFilters').attr('action');

$(".cancel_filters").live("click",function()
{
	window.location.href = urlFilter + $(this).attr('href');
	return false;
	
});

$(".show_filters").live("click",function()
{
	if(filterState == "show")
	{
		filterState = "hide";
		$(".filtros").fadeOut('slow');
	}
	else
	{
		filterState = "show";
		$(".filtros").fadeIn('fast');
	}
	return false;
	
});

$(".show_filters").live("keypress",function()
{
	return false;
});