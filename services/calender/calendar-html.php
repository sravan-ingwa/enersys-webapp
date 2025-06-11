<?php
$monthNames = Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
$cDate = date("d");
$cMonth = date("n");
$cYear = date("Y");
$timestamp = mktime(0,0,0,$cMonth,1,$cYear);
$maxday = date("t",$timestamp);
$thismonth = getdate ($timestamp);
$startday = $thismonth['wday'];
for ($i=0; $i<($maxday+$startday); $i++) {
    if(($i%7)==0) $ax.="<tr align='center'>";
    if($i<$startday) $ax.="<td style='border:1px solid #e0e0e0;'>&nbsp;</td>";
    else{
		if($cDate==($i - $startday + 1))$ax.="<td style='border:1px solid #e0e0e0;background:#31527b;color:#FFF;'>". ($i - $startday + 1) . "</td>";
		else $ax.="<td style='border:1px solid #e0e0e0;'>". ($i - $startday + 1) . "</td>";
	}
	if(($i%7)==6 ) $ax.="</tr>";
}
$body = "<html><body style='margin:0;padding:10px;font-size:100%;font-family:Calibri;'>";
	$body .="<table align='center' cellpadding='5' width='40%'>";
		$body .="<tr>";
			$body .="<th style='border-bottom:2px solid #31527b; border-top:2px solid #31527b; text-align:left;color:#31527b;'>";
				$body .="<h5 style='margin:0px; font-size:14px;line-height:20px;'>JAGAN BABU Calendar</h5>";
				$body .="<p style='margin:0px; font-size:14px;line-height:20px;'>jaganbabu@mymgs.com</p>";
				$body .="<p style='margin:0px; font-size:14px;line-height:20px;'>On 31 October 2015</p>";
			$body .="</th>";
		$body .="</tr>";
	$body .="</table>";

	$body .="<table align='center' cellpadding='6' width='20%' style='border-collapse:collapse;color:#31527b;'>";
		$body .="<tr align='center'>";
			$body .="<td colspan='7'><strong>".($monthNames[$cMonth-1]." ".$cYear)."</strong></td>";
		$body .="</tr>";
		$body .="<tr>";
			$body .="<th style='border:1px solid #e0e0e0;'><span>SUN</span></th>";
			$body .="<th style='border:1px solid #e0e0e0;'><span>MON</span></th>";
			$body .="<th style='border:1px solid #e0e0e0;'><span>TUE</span></th>";
			$body .="<th style='border:1px solid #e0e0e0;'><span>WED</span></th>";
			$body .="<th style='border:1px solid #e0e0e0;'><span>THU</span></th>";
			$body .="<th style='border:1px solid #e0e0e0;'><span>FRI</span></th>";
			$body .="<th style='border:1px solid #e0e0e0;'><span>SAT</span></th>";
		$body .="</tr>";
		$body .=$ax;
	$body .="</table><br>";
    
	$body .="<table align='center' width='40%' cellpadding='5'>";
		$body .="<tr style='background-color:#e0e0e0;color:#31527b;'> ";
			$body .="<th align='left' >October 2015</th>";
		$body .="</tr>";
	$body .="</table>";
    
	$body .="<table align='center' cellpadding='8' width='35%' style='color:#31527b;border-bottom:1px solid #e0e0e0; border-top:1px solid #e0e0e0; text-align:left; margin-top:10px;'>";
		$body .="<tr>";
			$body .="<th valign='top' width='20%'>31 Oct</th>";
			$body .="<td>";
				$body .="<ul>";
				$body .="<li>Event 1<br>absent</li>";
				$body .="</ul>";
			$body .="</td>";
		$body .="</tr>";
	$body .="</table>";
$body.="</body></html>";
echo $body;
?>
