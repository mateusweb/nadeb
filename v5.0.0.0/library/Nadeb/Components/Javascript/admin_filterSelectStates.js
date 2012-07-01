$("#select_states_filter").change(function()
{
	var select_filter = $("#select_states_filter").val();	
	window.location.href = urlFilter + "filter/type/selectStates/select_states_filter/" + select_filter;
});