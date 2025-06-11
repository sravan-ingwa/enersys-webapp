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
<div class="well">
  <table class="table">
    <thead>
      <tr>
        <th>Check in: <input type="text"  id="dpd1"></th>
                 <th>Check other: <input type="text" class="dpd2"></th>

        <th>Check out: <input type="text" class="dpd2"></th>
        
      </tr>
    </thead>
  </table>
</div>
<script>
var nowTemp = new Date();
var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
	var checkin = $('#dpd1').datepicker({
		format: 'dd-mm-yyyy',
		onRender: function(date){return date.valueOf() > now.valueOf() ? 'disabled' : '';}
	}).on('changeDate', function(ev){		
		if (ev.date.valueOf() < checkout.date.valueOf()) {
			var newDate = new Date(ev.date);
			newDate.setDate(newDate.getDate());
			checkout.setValue(newDate);
		}
		var sDate = $('#dpd1').val();
		var eDate = $('.dpd2').val();
		checkin.hide();
	}).data('datepicker');
	var checkout = $('.dpd2').datepicker({
			format: 'dd-mm-yyyy',
			onRender: function(date){
				if(date.valueOf() < checkin.date.valueOf() || date.valueOf() > now.valueOf()) return 'disabled';
				else return'';
			}
		}).on('changeDate', function(ev){
			checkout.hide();
			var sDate = $('#dpd1').val();
			var eDate = $('.dpd2').val();
	}).data('datepicker');
</script>
           
</body>
</html>