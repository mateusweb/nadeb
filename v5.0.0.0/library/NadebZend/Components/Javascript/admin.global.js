var clrTimer;

function show_aviso(msg)
{
	var close = '<a class="hideNadebAviso" href="#"> x </a>';
	var msg = close + msg;
	$("#avisos").show();
	$("#avisos").html(msg);
	/*hide_aviso();*/
};

function hide_aviso()
{
	$("#avisos").hide();
	/*
	if( clrTimer ) clearTimeout(clrTimer);
	clrTimer = setTimeout(
		function()
		{
			$("#avisos").slideUp('slow',function(){$(".hide").hide();});
			return false;
		}
		, 4000
	)*/
};

function isNumeric(value)
{
	var isNumber = true;
	var valid    = "0123456789.";
	var char;
	for (i=0;i<value.length && isNumber == true;i++)
	{
		char = value.charAt(i); 
		if (valid.indexOf(char) == -1)
		{
			isNumber = false;
		}
	}
		
	return isNumber;
};

function createCookie(name,value,days)
{
	if (days) 
	{
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) 
{
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) 
	{
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function eraseCookie(name) 
{
	createCookie(name,"",-1);
}

function queryStr(str) 
{
	var url = window.location.href;
	var start = url.indexOf(str + '/');
	var params = url.substring(start).split('/');
	
	var result = {
			'val' : params[1],
			'fullVal' : str + '/' + params[1]
	};
	
	return result;
}