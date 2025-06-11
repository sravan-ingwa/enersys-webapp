<?php
$reg_id='APA91bHccDFGhQJ90lIVU7ZCRDbndFEl79ktLnI39xGS5uunWUT6Ezc771FQsXviDkBzjJlMBVeSF80lM6CdGs6R_HD-u0Pw-chqyx9KqBZMjfkSX8VrABf4wKQ3yAZF8whvr1foN13f50p7Z622FJfsZkxIVWz24g';
$mssg="sfrgf";
// API access key from Google API's Console
define('API_ACCESS_KEY', 'AIzaSyCPr4vEYPiylMHvnV--vULqzK4wBMQuGYU');
$registrationIds = array($reg_id);
// prep the bundle
$msg = array('message' 	=> $mssg);
$fields = array(
	'registration_ids' 	=> $registrationIds,
	'data'			=> $msg
);
$headers = array(
	'Authorization: key=' . API_ACCESS_KEY,
	'Content-Type: application/json'
);
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
$result = curl_exec($ch );
curl_close( $ch );

?>