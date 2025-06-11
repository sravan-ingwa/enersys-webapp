<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link rel="stylesheet" href="css/bootstrap.css">

<link href="css/datepicker.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
</head>

<body>
<input type="text" class="dpd1" value="02-16-2012" >
<input type="text" class="dpd1" value="02-16-2012" >


<script>
var disabledDates = [];

var nowTemp = new Date();
var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
 
var checkin = $('.dpd1').datepicker({
  onRender: function(date) {
    //return date.valueOf() <= now.valueOf() ? 'disabled' : '';
  }
}).on('changeDate', function(ev) {
    var newDate = new Date(ev.date)
    newDate.setDate(newDate.getDate() + 1);
    checkin.setValue(newDate);
	$('.dpd1').datepicker({
  onRender: function(date) {
	return date.valueOf() == checkin.date.valueOf() ? 'disabled' : '';
  }
  }).data('datepicker');

	//return date.valueOf() == checkin.date.valueOf() ? 'disabled' : '';

}).data('datepicker');
</script>
           
</body>
</html>