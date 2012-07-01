$(".set_swap").click(function()
{
	var swpID = $(this).attr('id');
	img = $('#' + swpID + ' img').attr('src');
	
	if (img.indexOf('set_1.gif') == -1)
	{
		$('#' + swpID + ' img').attr('src', img.replace('set_0', 'set_1') );
	}
	else
	{
		$('#' + swpID + ' img').attr('src', img.replace('set_1', 'set_0') );
	}
	
	url = $(this).attr("href");
	$("#avisos").load(url);
	
	return false;
});

$("th.td_checkbox").html("<input name='selectAll' id='selectAll' type='checkbox' value='' />");
$("th.td_checkbox input").live("change",function()
{
	$("td.td_checkbox input").attr("checked",$(this).attr("checked"));
});

$(".edit_move").live('mouseup',function()
{
	$("tbody").sortable( 'disable' );
	
}).live('mousedown',function()
{
	$("tbody").sortable();
	$("tbody").sortable( 'enable' );
});
	
$("tbody").bind('sortbeforestop', function(event, ui) 
{
	show_aviso('atualizando dados...');
	
	var i = 0;
	var ar_id = new Array();
	var url = $(".edit_move a").attr("href");
	
	$("form .td_checkbox input").each(function()
	{
		if( $(this).val() != '' )
		{
			ar_id[i++] = $(this).val();
		}
	});
	$("#avisos").load(url + "/neworder/"+ar_id, function(data){
		show_aviso(data);
	});
});

$(".edit_move a").live('mouseover',function()
{
	$("tbody").sortable();
	return false;
});

$(".edit_move a").live('click',function()
{
	return false;
});

$('.edit_excluir a').live('click',function()
{
	if( !confirm('Tem certeza que deseja este registros?') ) return false;
	
	$('#avisos').load( $(this).attr('href') + '/ajax/true/', function(data)
	{
		show_aviso(data);
	});
	
	$(this).parents("tr").hide();
	return false;
});

$('.bot_excluir').live('click',function()
{
	hide_excludes_ck();
});

$('.delete_button').live('click',function()
{
	if( !confirm('Tem certeza que deseja remover os registros?') ) return false;
	/*hide_excludes_ck();*/
});

/*
function hide_excludes_ck()
{
	$("td.td_checkbox input").each(function(i)
	{
		if( this.checked )
		{
			$(this).parents("tr").hide();
		}
	});
};
*/

$('th.td_checkbox input').live('click',function()
{
	$("td.td_checkbox input").each(function(i)
	{
		if( this.checked )
		{
			this.checked = false;
		}
		else
		{
			this.checked = true;
		}
	});
});

function showRequest(formData, jqForm, options)
{ 
	var queryString = $.param(formData); 
	return true; 
};
 
function showResponse(responseText, statusText)
{ 
	/*$("#avisos").show();
	hide_aviso();*/
	
	show_aviso(responseText);
	$("td.td_checkbox input").each(function(i)
	{
		if( this.checked )
		{
			$(this).parents("tr").hide();
		}
	});
};

var options = { 
	target       :'#avisos', 
	beforeSubmit :showRequest, 
	success      :showResponse,
	url:          $('form#fGrid').attr('action') + 'ajax/true'
};

$('form#fGrid').ajaxForm(options);

