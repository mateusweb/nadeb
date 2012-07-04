var controller;
var label;
var value;
var controllers = [];
var permissions = [];

/*
 * Controllers
 */
$("#controllers-object label").each(function(i,obj) {$(obj).addClass('id'+ i);});
controller  = '<ul>';
$("#controllers-object label").each(function(i)
{
	label = $('label.id'+ i +' span').html();
	value = $('label.id'+ i +' input').val();
	if( label != 0)
	{
		controllers.push(value);
		controller += '<li class="id'+ i +'">';
		controller += '<a href="#read">leitura</a> <a href="#write">escrita</a> <strong>'+ label +' </strong>';
		controller += '</li>';
	}
	else
	{
		controllers.push('x'+i);
	}
});
controller += '</ul>';
controller += '<input type="hidden" name="controllers" value="'+ controllers +'" id="controllers" class="controllers" />';
$("#controllers-object").html(controller);

/*
 * Permission
 */
var permission = $('#permission').val().split(',');
if(permission.length == controllers.length) 
{
	permissions = permission;
}
else
{
	for(i = 0; i < controllers.length; i++) (permission[i]) ? permissions.push( permission[i] ) : permissions.push(0);
}
$("#permission").val(permissions);

for(i = 0; i < permissions.length; i++) 
{
	if( permissions[i] == 1 ) 
	{
		$('li.id'+ i +' strong').addClass('open');
		$('li.id'+ i +' a[href=#write]').removeClass('open');
		$('li.id'+ i +' a[href=#read]').addClass('open');
	}
	if( permissions[i] == 2 ) 
	{
		$('li.id'+ i +' strong').addClass('open');
		$('li.id'+ i +' a[href=#write]').addClass('open');
		$('li.id'+ i +' a[href=#read]').addClass('open');
	}
	if( permissions[i] == 0 ) 
	{
		$('li.id'+ i +' strong').removeClass('open');
		$('li.id'+ i +' a[href=#write]').removeClass('open');
		$('li.id'+ i +' a[href=#read]').removeClass('open');
	}
}


$("#controllers-object a").click(function()
{
	var index = $(this).parent('li').attr('class').replace('id','');
	var type  = $(this).attr('href').split('#');
	type      = ( type[1] == 'read' ) ? 1 : 2;
	
	if( type == 1 && permissions[index] == 1 ) type = 0;
	if( type == 2 && permissions[index] == 2 ) type = 1;
	if( type == 1 && permissions[index] == 2 ) $('li.id'+index+' a[href=#write]').removeClass('open');
	if( type == 1 ) 
	{
		$('li.id'+ index +' strong').addClass('open');
		$('li.id'+ index +' a[href=#write]').removeClass('open');
		$('li.id'+ index +' a[href=#read]').addClass('open');
	}
	if( type == 2 ) 
	{
		$('li.id'+ index +' strong').addClass('open');
		$('li.id'+ index +' a[href=#write]').addClass('open');
		$('li.id'+ index +' a[href=#read]').addClass('open');
	}
	if( type == 0 ) 
	{
		$('li.id'+ index +' strong').removeClass('open');
		$('li.id'+ index +' a[href=#write]').removeClass('open');
		$('li.id'+ index +' a[href=#read]').removeClass('open');
	}
	
	permissions.splice(index,1,type);
	$("#permission").val(permissions);

	/*( $(this).attr('class') ) ? $(this).removeClass('open') : $(this).addClass('open');*/

	return false;
	
});


/*<input type="text" name="permission" value="read,write" id="permission" class="permission" />*/
