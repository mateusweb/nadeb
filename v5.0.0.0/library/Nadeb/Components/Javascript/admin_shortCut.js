document.onkeydown = function(e)
{
	var keychar;
	try 
	{
		keychar = String.fromCharCode(event.keyCode);
		e = event;
	}
	catch(err) 
	{
		keychar = String.fromCharCode(e.keyCode);
	}
	
	if (e.ctrlKey && e.altKey && keychar == 'A') 
	{
		var model = prompt("Informe o nome da tabela, sem o prefixio para gerar o crud:");
		if (model)
		{
			window.location = "/admin/inicial/crud/modelo/" + model;
		}
		return false;
	}
};