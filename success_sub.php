<h2>Success return report of Ticket Objects</h2>
<input type="button" onclick="location.reload()" value="Refresh"/></br></br>
<?php
/*$path = "mobile_app/ticket_objects/";
$files = scandir($path);
foreach ($files as $value)echo "<a href='http://enersyscare.co.in/".$path.$value."' target='_black' >".$value."</a><br/>";
*/
$path="mobile_app/ticket_objects/success/";
foreach(scan_dir($path) as $k=>$value)echo ($k+1).".&nbsp; <a href='http://enersyscare.co.in/".$path.$value."' target='_black' >".$value."</a><br/>";
function scan_dir($dir) {
    $ignored = array('.', '..', '.svn', '.htaccess');
    $files = array();    
    foreach (scandir($dir) as $file) {
        if (in_array($file, $ignored)) continue;
        $files[$file] = filemtime($dir . '/' . $file);
    }
    arsort($files);
    $files = array_keys($files);
    return ($files) ? $files : false;
}
?>