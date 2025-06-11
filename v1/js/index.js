$(window).load(function(){$(".loadx").fadeOut(200);});
$(function(){
	$('.test-jquery-click').click(function() {
		$.ajax({
				type: "POST",
				url: "delete.php",
				data: 'del='+$(this).attr('data'),
				cache: false,
				success: function(result){
					document.getElementById("myText").innerHTML = "<div class='alert alert-success' role='alert'>Successfully Deleted</div>";
					setTimeout(function(){window.location='index.php?x='+result;}, 1000);
				/*location.reload();*/ }
			});
	});
	$(".popconfirm").popConfirm();
	$('.tooltips').tooltip();
});
$(document).ready(function(){
	for(var z = 0; z < $("#countt").val(); z++){
		(function(z) { func(z);
			$("#itemSelect" + z +", #stockSelect"+ z).on('change',function(){ func(z); });
		})(z)
    }
	function func(z){
		var ware = $("#wh" + z).val();
		var itm = $("#itemSelect" + z).val();
		var stock = $("#stockSelect" + z).val();
		$.ajax({type: "POST",url: "ajaxInventBalance.php",data: "wh=" + ware + "&itm=" + itm + "&stk=" + stock + "&z=" + z + "&ref=invBal",cache: false,success: function(res) {
				var g = res.split(", ");
				var n = g[g.length - 1];
				for (var i = 0; i < g.length; i++) {
					$("#matIn" + n).html(g[0]);
					$("#matOut" + n).html(g[1]);
					$("#balanceStk" + n).html(g[2]);
					if(g[0] == 0) { $("#hideView" + n).hide(); }
				}
			}})
		}
});