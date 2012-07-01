function showRequest(formData, jqForm, options)
{ 
	var queryString = $.param(formData); 
	return true; 
};
 
function showResponse(responseText, statusText)
{
	var html = responseText;
	
	html += '<a class="voltar_button" href="#">Voltar</a>';  
	html += (window.location.href.indexOf('/id/') != -1) 
		? '<a class="edit_button" href="'+window.location.href+'">Alterar novamente</a>' 
		: '<a class="insert_button" href="'+window.location.href+'">Inserir Novo</a>';  
	
	$('form').html(html);
	$('form#formJsfolder').html('');
};

var options = { 
	url          :($('form').attr('action') + '/ajax/true').replace('//','/'),
	target       :'form', 
	beforeSubmit :showRequest, 
	success      :showResponse
};

$('form').ajaxForm(options);

$('.btn_cancel, .voltar_button').live('click',function()
{
	/*
	var form = $('form').attr('action');
	form = form.split("edit");
	
	window.location.href = form[0] + 'list/';
	*/

	window.history.go(-1);
	return false;
});

$('.clearFolder').click(function()
{
	show_aviso('removendo arquivos...');
	$("#avisos").load( $(this).attr("href"), function()
	{ 
		$('.linkRed').hide();
	});
	return false;
});

$('input[type=file]').each(function()
{
	var obj = $(this);
	var fakeName = obj.attr('id') + 'Fake';
	obj.parent().append('<input id="'+fakeName+'" class="fakeUpload" value="Clique para selecionar um arquivo" type="text"  disabled="disabled" />');
	
	obj.change(function()
	{
		$('#'+fakeName).val( obj.val() );
	});
	
});
