if(typeof(apapp) === "undefined") { apapp = {}; }

apapp.item_list = function()
{

};

apapp.item_list.prototype.init = function()
{
	var that = this;
	$('#type').change(function() { that.filter(); })
	$('#cost').change(function() { that.filter(); })
	$('#name').keyup(function() { that.filter(); })
	$('#expanded').change(function() { that.toggleExpanded(); })

	this.filter();	

	$('ul#item-list.expanded li .long ol li strong').each(function()
	{
		var color = (parseInt($(this).html()) >= 0) ? "green" : "red";
		$(this).css('color', color);
	});
};

apapp.item_list.prototype.filter = function()
{
	var type = $('#type').val();
	var cost = $('#cost').val();
	var name = $('#name').val();

	var selector = "";
	if(type)
	{
		selector += "." + type;
	}

	$('ul#item-list > li').show();

	$('ul#item-list > li:not(' + selector + ')').hide();
	$('ul#item-list > li').filter(function() 
	{
    	return  parseInt($(this).attr("data-cost")) < cost;
	}).hide();

	$('ul#item-list > li').filter(function() 
	{
		var reg = new RegExp(name, 'i');
    	return !reg.test($(this).find('.champion-name').html());
	}).hide();
};

apapp.item_list.prototype.toggleExpanded = function()
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

var item_list = new apapp.item_list();
$(document).ready(function()
{
	item_list.init();
});