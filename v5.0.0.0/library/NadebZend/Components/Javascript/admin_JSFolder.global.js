var liIndexFiles = 0;
var folder       = "";
var pathLocation = window.location.toString(); 
/*var root         = pathLocation.indexOf("/id/") == -1 ? "../" : root = "../../";*/
var flashPath    = '';
var diff         = pathLocation.indexOf("/id/") == -1 ? 2 : 3;
var arrFlashPath = pathLocation.split('/');

var root         = '';
for(i = 0; i < 5; i++) root += arrFlashPath[i] + '/';

var JSEditorOptions = { 
		target:       '#avisos',
		success:      show_JSEditorResponse,
		url:          root + 'add-to-folder/folder/' + folder
};

flashPath = root;

/*
for(i = 0; i < (arrFlashPath.length-diff); i++)
	flashPath += arrFlashPath[i] + '/';
*/

function show_JSEditorResponse(responseText, statusText)
{
	show_aviso(responseText);
	get_JSEditorJson();
}

function save_legenda()
{
	dados = "";
	$(".folder li").each(function(i)
	{
		obj = $(this).attr("id");
		dados += "legenda[]="+$("#" + obj + " input").val()      + "&";
		dados += "file[]="   +$("#" + obj + " input").attr("id") + "&";
	});
	
	show_aviso('salvando legendas...');
	$.post(root + "save-legend/folder/"+ folder,dados, function(data){show_aviso(data);});
}

function get_JSEditorJson()
{
	getULFolder();
	$.getJSON(root + 'list-folder/folder/' + folder, function(data)
	{
		var arr = (data) ? data : '';
		
		for(var i = 0; i < arr.length; i++)
		{
			$("#jsfolder div ul").append( getLIFolder(arr[i].file) );
		}
	});
};

function JSEditorShowLastFile(file)
{
	getULFolder();
	$("#jsfolder div ul").append( getLIFolder(file) );
}

function getULFolder()
{
	if( !$("#jsfolder div").html() ) $("#jsfolder div").html("<ul class='folder'></ul>");	
}

function getLIFolder(file)
{
	var root_path = $('#root_path').attr('class');
	var xhtml =	"<li id='file"+ liIndexFiles +"'>" +
					"<a href='__ROOT__public/uploads/"+folder+"/"+file+"' class='lightbox'>" +
						"<img src='__ROOT__public/uploads/"+folder+"/temp/nadeb-temp-"+file+"' heigth='100' width='100' />" +
					"</a>" +
					"<input type='text' name='legenda' id='"+file+"' value='' />" +
					"<a href='" + root + "del-to-folder/folder/"+folder+"/file/"+file.replace(".","/ext/")+"' class='excluir deleteFiles'>[x]</a>" +
				"</li>";
	
	liIndexFiles++;
	
	return 	xhtml;
}









