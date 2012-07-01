
/** CONSULTA ESTADO E CIDADE **/
function selectCityState(_state, _city)
{
	var urlStates = "/public/XMLCities/states.xml";
	var urlCities = "/public/XMLCities/cities/";
	var city = _city;
    var state = _state;
	
	var initState = state.html();
	initState = initState.length == 30 ? "" : state.html();

	$.get(urlStates,function(xml)
	{
		var stateHTML = initState + '';
		$(xml).find('state').each(function(i)
		{
			stateHTML += '<option value="'+ $(this).attr('abbr') +'">'+ $(this).attr('abbr') +'</option>';
			if( parseInt($(xml).find('state').length -1) == parseInt(i) )
			{
				state.html( stateHTML );
			}
		});
	});
	
	state.change(function()
	{
		city.attr('disabled','disabled');
		city.html('<option value=""> carregando... </option>');
		$('#cit_name-object span').html( 'carregando...' );
		$.get(urlCities + $(this).val().toLowerCase() +".xml",function(xml)
		{
			var citiesHTML = '';
			$(xml).find('city').each(function(i)
			{
				if( parseInt(i) == 0 )$('#cit_name-object span').html( $(this).attr('name') );
				citiesHTML += '<option value="'+ $(this).attr('name') +'">'+ $(this).attr('name') +'</option>';
				if( parseInt($(xml).find('city').length -1) == parseInt(i) )
				{
					city.html(citiesHTML);
					city.removeAttr('disabled');
				}
			});
		});
	});
	/** CONSULTA ESTADO E CIDADE **/	
}