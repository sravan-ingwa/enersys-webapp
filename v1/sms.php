<?php
$ch=curl_init();
$numberx=9701234870;
$messagex=urlencode( "Greetings from Enersys, your complaint has been registered against the Warranty Support of Site name-ENhdsj Ticket No- 897883");
curl_setopt($ch, CURLOPT_URL, "http://bhashsms.com/api/sendmsg.php?user=enersyscare&pass=sairaam@5050&sender=EnrSys&phone=".$numberx."&text=".$messagex."&priority=ndnd&stype=normal");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);  


?>