folder   = $("input#"+$("#jsfolder").attr("class")).val();

var params = {
	menu: "false",
	scale: "noScale",
	allowFullscreen: "true",
	allowScriptAccess: "always",
	wmode: 'transparent'
};
var attributes = {
	id:"flashBrowser"
};
var flashvars = {
	root: flashPath,
	folder: folder
};

swfobject.embedSWF(
	'__ROOT__library/Nadeb/flashBrowser/flashBrowser.swf',
	'flashBrowser',
	'270px',
	'50px',
	'9.0.45',
	'',
	flashvars, params, attributes
);

$('#jsfolder input').hide();

get_JSEditorJson();

$('.addfolder').click(function()
{
	$("#jsfolder form").ajaxSubmit(JSEditorOptions);
});

$(".deleteFiles").live("click",function()
{
	url = $(this).attr("href");
	$(this).parent("li").remove();
	
	$.post(url, function(data)
	{
		save_legenda();
		show_aviso(data);
	});
	
	return false;
});

$(".save_legend").click(function()
{
	show_aviso("Legendas salvas som sucesso!");
	save_legenda();		
	return false;
	
});
