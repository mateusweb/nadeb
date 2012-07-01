var intervalo;
var urlSearch;
var urlForm = $('#search form').attr('action') + '/ajax/true/';
var searchParams = {};

$("#search h4 a").click(function()
{
	( $("#search").attr('class') == 'show' ) ? $("#search").removeClass('show') : $("#search").addClass('show');
	
	return false;
});

$(".search-form").submit(function()
{
	return false;
});

$("#search .inputSearch").keyup(function()
{
	showLoader();
	var inputName = $(this).attr('name');
	searchParams[ inputName ] = ( $(this).val().length >= 1 ) ? ( $(this).attr('name') + '/' + $(this).val() ) : '';
	
	if( intervalo ) clearInterval(intervalo);
		
	intervalo = setTimeout(loadSearch, 2000);
});

$("#search .selectSearch").change(function()
{
	showLoader();
	var inputName = $(this).attr('name');
	searchParams[ inputName ] = ( $(this).val() ) ? ( $(this).attr('name') + '/' + $(this).val() ) : '';
	loadSearch();
});

$("#start_date").click(clearDate);
$("#end_date").click(clearDate);

$("#start_date").datepicker({
	dateFormat: 'yy-mm-dd',
	onSelect: function(dateText, inst)
	{
		$("#end_date").val('');
	}
});

$("#end_date").datepicker({
	dateFormat: 'yy-mm-dd',
	onSelect: function(dateText, inst) 
	{
		var start_date = $("#start_date").val();
		var end_date   = $("#end_date").val();
		var inputName  = $(this).parents('dd').attr('id').replace('Param','');
		
		searchParams[ inputName ] = '/dateBetween/true/start_date/' + start_date + "/end_date/" + end_date;
		showLoader();
		loadSearch();
	}
});

function getUrlSearch()
{
	var url;
	urlSearch = '';
	$('#search form dd').each(function()
	{
		var inputName  = $(this).attr('id').replace('Param','');
		if( searchParams[inputName] ) urlSearch += searchParams[inputName] + '/';
	});
	url = (urlForm + '/' + urlSearch);
	url = url.replace(/\/\/+/g,'/');
	
	return url;
}

function clearDate()
{
	var inputName = $(this).parents('dd').attr('id').replace('Param','');
	searchParams[ inputName ] = '';
	
	$(this).val('');
}

function showLoader()
{
	if( !$('.ajaxSearch').html() )
	{
		$('#fGrid table tbody').html( '<tr><th colspan="99" class="ajaxSearch">buscando...</th></tr>' );
		$('body').append('<div id="resultSearch" style="display:none"></div>');
	}
}

function loadSearch()
{
	$('#resultSearch').load(getUrlSearch(), loadSearchComplete);
}

function loadSearchComplete()
{
	$('#fGrid table tbody').html( $('#resultSearch tbody').html() );
	$('#resultSearch').remove();
}


if( $('select[name=state]').attr('name') )
{
	var urlStates = "/public/XMLCities/states.xml";
	var urlCities = "/public/XMLCities/cities/";
	var state     = $('select[name=state]');
	
	var initState = state.html();
	initState = initState.length == 30 ? "" : state.html();

	$.get(urlStates,function(xml)
	{
		var stateHTML = initState + '<option value=""> - </option>';
		$(xml).find('state').each(function(i)
		{
			stateHTML += '<option value="'+ $(this).attr('abbr') +'">'+ $(this).attr('abbr') +'</option>';
			if( parseInt($(xml).find('state').length -1) == parseInt(i) )
			{
				state.html( stateHTML );
			}
		});
	});
}