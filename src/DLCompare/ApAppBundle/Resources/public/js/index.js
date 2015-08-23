$(document).ready(function() 
{ 
    $(".tablesorter").tablesorter({
        widgets : ["zebra", "columns"]
    });

    $(".tablesorter").bind("sortEnd", function() 
    {   
        $(this).find('tbody tr').removeClass('odd');
        $(this).find('tbody tr:odd').addClass('odd');
    });

    $('td.diff').each(function()
    {
        var color = (parseFloat($(this).html()) >= 0) ? "green" : "red";
        $(this).css('color', color);
    }); 

    $('.filter select').change(function()
    {
		$('#champions table tbody tr').show();
		$('#champions table tbody tr td.avatar:not(.' + $(this).val() + ')').each(function()
		{
			$(this).parent('tr').hide();
		})
        
        $('#champions table tbody tr:visible').removeClass('odd');
        $('#champions table tbody tr:visible:odd').addClass('odd');
    });
}); 
