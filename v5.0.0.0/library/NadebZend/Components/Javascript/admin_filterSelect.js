$("#select_filter").change(function()
{
	var select_filter = $("#select_filter").val();	
	window.location.href = urlFilter + "filter/type/select/select_filter/" + select_filter;
});