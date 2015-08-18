$(document).ready(function()
{
	$('ul.tabs li').click(function()
	{
		if($(this).hasClass('current')) { return ; }
		$(this).parent().find('li').removeClass('current');
		var id = $(this).attr('class');

		$('.tab').slideUp();
		$('#' + id).slideDown();
		$(this).addClass('current');
	});

	$('ul.tabs li:first').click();
});