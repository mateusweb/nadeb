if( $("#avisos").html() != "" )
{
	$("#avisos").show();
	hide_aviso();
};

$(".hideNadebAviso").live('click',function()
{
	$("#avisos").slideUp('slow',function()
	{
		$("#avisos").hide();
		$("#avisos").html('');
	});
	
	return false;
});

$(".sideBarTitle").click(function()
{
	var obj = $(this).attr('href') + 'Menu';
	
	( readCookie(obj.replace('#','')) == 'show' ) ? hide(obj) : show(obj);
	
	return false;
});
	
function show(obj)
{
	$(obj).show();
	createCookie( obj.replace('#',''), 'show', 99);
}

function hide(obj)
{
	$(obj).hide();
	createCookie( obj.replace('#',''), 'hide', 99);
}

$('.sidebar ul ul').each(function()
{
	$(this).hide();
	
	( !readCookie( $(this).attr('id') ) ) ? createCookie( $(this).attr('id'), 'hide', 99) : ( readCookie($(this).attr('id')) == 'show' ) ? show('#'+$(this).attr('id')) : hide('#'+$(this).attr('id'));
});


$("a[rel=external]").attr("target","_blank");
$('body').prepend('<div id="avisos"></div>');