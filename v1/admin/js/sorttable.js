include('jquery.tablesorter.js');
include('jquery.tablesorter.widgets.js');
include('jquery.tablesorter.pager.js');
function include(url){document.write('<script type="text/javascript" src="js/'+ url+'"></script>');return false;}
$(function() {
$.extend($.tablesorter.themes.bootstrap, {
	// these classes are added to the table. To see other table classes available,
	// look here: http://twitter.github.com/bootstrap/base-css.html#tables
	table      : 'table table-bordered',
	caption    : 'caption',
	header     : 'bootstrap-header', // give the header a gradient background
	footerRow  : '',
	footerCells: '',
	icons      : 'icon-white', // add "icon-white" to make them white; this icon class is added to the <i> in the header
	sortNone   : 'bootstrap-icon-unsorted  hidden-xs  hidden-sm',
	sortAsc    : 'icon-chevron-up glyphicon glyphicon-chevron-up  hidden-xs ',     // includes classes for Bootstrap v2 & v3
	sortDesc   : 'icon-chevron-down glyphicon glyphicon-chevron-down hidden-xs', // includes classes for Bootstrap v2 & v3
	active     : '', // applied when column is sorted
	hover      : '', // use custom css here - bootstrap class may not override it
	filterRow  : '', // filter row class
	even       : '', // odd row zebra striping
	odd        : ''  // even row zebra striping
});
$("table").tablesorter({
	theme : "bootstrap",
	widthFixed: true,
	headerTemplate : '{content} {icon}', // new in v2.7. Needed to add the bootstrap icon!
	widgets : [ "uitheme", "filter", "zebra" ],
	widgetOptions : {
		zebra : ["even", "odd"],
		filter_reset : ".reset"
	}
})
.tablesorterPager({
	container: $(".ts-pager"),
	cssGoto  : ".pagenum",
	removeRows: false,
	output: '{startRow} - {endRow} / {filteredRows}'
});
});