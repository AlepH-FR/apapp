if(typeof(apapp) === "undefined") { apapp = {}; }

apapp.champion_list = function()
{

};

apapp.champion_list.prototype.init = function()
{
	var that = this;
	$('#type').change(function() { that.filter(); })
	$('#name').keyup(function() { that.filter(); })
	$('#expanded').change(function() { that.toggleExpanded(); })

	this.filter();

	$('ul#item-list.expanded li .long ol li strong').each(function()
	{
		var color = (parseInt($(this).html()) >= 0) ? "green" : "red";
		$(this).css('color', color);
	});
};

apapp.champion_list.prototype.toggleExpanded = function()
{
	var expanded = $('#expanded').val();

	if(expanded == "expanded")
	{
		$('ul#item-list').addClass('expanded');
	}
	else
	{
		$('ul#item-list').removeClass('expanded');
	}
};

apapp.champion_list.prototype.filter = function()
{
	var type = $('#type').val();
	var name = $('#name').val();

	var selector = "";
	selector += "." + type;

	$('ul#item-list > li').show();

	$('ul#item-list > li:not(' + selector + ')').hide();

	$('#item-list > li').filter(function() 
	{
		var reg = new RegExp(name, 'i');
    	return !reg.test($(this).find('.champion-name').html());
	}).hide();
};

var champion_list = new apapp.champion_list();
$(document).ready(function()
{
	champion_list.init();
});