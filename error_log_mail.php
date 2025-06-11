<?php

/**
 * A script that can be called from cron to automatically email the content
 * of a PHP error log file to a developer or webmaster.
 *
 * Author: James Caws
 * Website: http://www.jamescaws.com
 *
 * It uses the freely available PHPMailer class available from
 *   http://sourceforge.net/project/showfiles.php?group_id=26031
 *
 * This particular script has been configured to use SMTP, but it's a piece of cake
 * to modify to use mail() and can even use sendmail if you make a few simple
 * changes to configure PHPMailer to do so.
 *
 * This version of the script is using PHPMailer v2.0.2
 * For help on all PHPMailer config issues and errors, refer to their documentation
 * and website at http://phpmailer.codeworxtech.com/
 *
 * Ensure that all of your website PHP scripts include the following through a common
 * include file or at the very top before anything else. 
 *
 *     ini_set('display_errors','0');			// Best practise on production sites
 *     ini_set('log_errors','1');			// We need to log them otherwise this script will be pointless!
 *     ini_set('error_log','/path/to/error_log');	// Full path to a writable file - include the file name
 *     error_reporting(E_ALL ^ E_NOTICE);		// What errors to log - see: http://www.php.net/error_reporting
 *
 * OR alternatively and more highly recommended, adjust php.ini or configure a .htaccess file if you can't do that.
 * See http://perishablepress.com/press/2008/01/14/advanced-php-error-handling-via-htaccess/ for details and examples
 *
 * NOTE : READ ALL OF THE COMMENTS IN THIS FILE TO UNDERSTAND HOW IT WORKS. IT
 * IS PARTICULARLY IMPORTANT YOU DO SO IF YOU DO NOT WANT TO USE THE PHPMAILER
 * CLASS AS YOU WILL NEED TO COMMENT OUT OR REMOVE CODE.
 */

/**
 * Set a few constants for ease of configuration
 */
 
define('ERROR_NOTIFY_MOBILE2','8499993795');			// Ravi Kiran
define('ERROR_NOTIFY_EMAIL3','ravikiran.d@enersys.co.in');	// Where the errors should be emailed
define('ERROR_NOTIFY_EMAIL2','ramanachari@enersys.co.in');	// Where the errors should be emailed

define('ERROR_NOTIFY_MOBILE','9959888778'); // ManiRaj
define('ERROR_NOTIFY_EMAIL','maniraj@enersys.co.in');	// Where the errors should be emailed
define('ERROR_NOTIFY_FROM_EMAIL','enersyscare_no_reply@enersys.com.cn');	// The 'from' address to use in outgoing emails
define('ERROR_NOTIFY_FROM_NAME','PHP Mail Error Log Monitor');	// The 'from name' to use in outgoing emails
define('ERROR_NOTIFY_SUBJECT','PHP Mail Error Log Report');	// Give the email a subject. Might come in useful if setting up a mailbox filter
define('ERROR_LOG_FILE','../sendmail/error.log');		// The full path to your readable + writable error file as defined by PHP config value 'error_log'
define('MAX_CONTENT_SIZE',1024);			// As a precaution, set the max size of the error log content to be emailed in case it grows exponentially

/**
 * The following is not required if you are happy for the default PHP mail()
 * function to be used. Some hosts don't allow it though or can be unreliable, so
 * you might want to use SMTP for better reliablity.
 */

//https://myaccount.google.com/security  Allow less secure apps: ON to run gmail stmp mails
 
/*$aMParams["host"] = 'smtp.office365.com';	// - The server to connect. Default is localhost
$aMParams["port"] = 587;			// - The port to connect. Default is 25
$aMParams["SMTPSecure"] = 'tls';
//$aMParams["SMTPAuth"] = true;
$aMParams["auth"] = true;		// - Whether or not to use SMTP authentication. Default is FALSE
$aMParams["username"] = 'enersyscare_no_reply@enersys.com.cn';	// - The username to use for SMTP authentication.
$aMParams["password"] = 'Enersys2015'; 	// - The password to use for SMTP authentication.
*/

$aMParams["host"] = 'smtp.gmail.com';	// - The server to connect. Default is localhost
$aMParams["port"] = 465;			// - The port to connect. Default is 25
$aMParams["SMTPSecure"] = 'ssl';
$aMParams["SMTPAuth"] = true;
$aMParams["auth"] = true;		// - Whether or not to use SMTP authentication. Default is FALSE
$aMParams["username"] = 'enersyscare@gmail.com';	// - The username to use for SMTP authentication.
$aMParams["password"] = 'Enersys123'; 	// - The password to use for SMTP authentication.



define('SMTP_MAIL_PARAMS',serialize($aMParams));	// remove this line if you are not using SMTP

/**
 * Carry out a few basic file checks first. This script will itself run in to problems if the error log
 * file does not exist, cannot be read or writen to.
 */

if (!file_exists(ERROR_LOG_FILE)) {
	mail(ERROR_NOTIFY_EMAIL, 'Error log file does not exist', sprintf("The file '%s' does not exist. Error log monitor cannot continue.", ERROR_LOG_FILE));
	exit;
} else if (!is_readable(ERROR_LOG_FILE)) {
	mail(ERROR_NOTIFY_EMAIL, 'Error log file is not readable', sprintf("The file '%s' is not readable. Error log monitor cannot continue.", ERROR_LOG_FILE));
	exit;
} else if (!is_writable(ERROR_LOG_FILE)) {
	mail(ERROR_NOTIFY_EMAIL, 'Error log file is not writable', sprintf("The file '%s' is not writable. Error log monitor cannot continue.", ERROR_LOG_FILE));
	exit;
}

/**
 * Check the error log filesize - no point carrying on if there is nothing in it.
 */
if (filesize(ERROR_LOG_FILE) == 0) { exit; }

/**
 * OK, so if we're still here there's work to do. 
 */

/**
 * Include the PHPMailer class. You still need this even if you have removed the above SMTP
 * configuration. If you DON'T want to use PHPMailer though, comment out this line and then
 * jump down to the comment 'Email it', remove the associated PHPMailer lines and uncomment
 * the mail() call.
 *
 * REMEMBER : class.phpmailer.php should be in the same location as this script, or
 * adjust the following line if it is somewhere else.
 */
//require_once('/services/functions.php');
require_once('/services/PHPMailer/PHPMailerAutoload.php');
//require_once('/services/PHPMailer/class.smtp.php');

/**
 * Retrieve the content from the file
 * and assign it to a couple of variables.
 */
$sContent = $sFullContent = file_get_contents(ERROR_LOG_FILE);

if(($pos = strpos($sContent, date('y/m/d'))) !== FALSE){
	$sContent = substr($sContent, $pos);
	$errors_count = substr_count($sContent,date('y/m/d'));
}else $errors_count=0;

if($errors_count == 0) { exit; }
elseif($errors_count > 5) $sContent = substr($sContent, 0, 700)."...";

/**
 * If we don't want to mail huge amounts of data, extract only the amount we do want.
 */
if (defined('MAX_CONTENT_SIZE') && MAX_CONTENT_SIZE > 0) {
	$sContent = substr($sContent, 0, MAX_CONTENT_SIZE);

	if (strlen($sFullContent) > MAX_CONTENT_SIZE) {
		$sContent .= "\n\n... Consult the error log archive for the full list of errors";
	}
}

/**
 * Email it.
 *
 * IF YOU DO NOT WANT TO USE PHPMAILER AND HAVE REMOVED THE require_once() INCLUSION ABOVE,
 * REMOVE ALL LINES BETWEEN HERE AND THE COMMENT "END OF PHPMAILER"
 */
$oMail = new PHPMailer();

/**
 * If we have SMTP detail held in a constant, use SMTP. Otherwise PHPMailer will default to using mail();
 */
if (defined('SMTP_MAIL_PARAMS')) {
	$aSMTP = unserialize(SMTP_MAIL_PARAMS);

	$oMail->isSMTP();	// set mailer to use SMTP
	$oMail->Host		= $aSMTP['host'];	// specify main and backup server
	$oMail->Port		= $aSMTP['port'];	// specify SMTP port
	$oMail->SMTPAuth	= $aSMTP['auth'];	// turn on SMTP authentication
	$oMail->SMTPSecure	= $aSMTP['SMTPSecure'];	// SMTP security
	$oMail->Username	= $aSMTP['username'];	// SMTP username
	$oMail->Password	= $aSMTP['password'];	// SMTP password
	$oMail->SMTPDebug	= 2;
}


//$oMail->addReplyTo('info@example.com', 'Information');
//$oMail->addCC('cc@example.com');
//$oMail->addBCC('bcc@example.com');

if($errors_count>5)$oMail->addAttachment(ERROR_LOG_FILE,'Error Log File');         // Add attachments
//$oMail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
//$oMail->isHTML(true);
//$oMail->AltBody = 'This is the body in plain text for non-HTML mail clients';

$oMail->addAddress(ERROR_NOTIFY_EMAIL, 'Mani Raj');
$oMail->addAddress(ERROR_NOTIFY_EMAIL2, 'Ramana Chari');
$oMail->addAddress(ERROR_NOTIFY_EMAIL3, 'Naresh');
$oMail->Body = $sContent;
$oMail->From = ERROR_NOTIFY_FROM_EMAIL;
$oMail->FromName = ERROR_NOTIFY_FROM_NAME;
$oMail->Subject = ERROR_NOTIFY_SUBJECT;
$oMail->Send();
	
if ($oMail->ErrorInfo && strlen($oMail->ErrorInfo)) {
	$sContent = sprintf("This message has been sent via the backup mail() function call as PHPMailer failed reporting: %s\n\n---\n\n%s",
		$oMail->ErrorInfo,
		$sContent
	);
	function messageSent($num,$msg){
		if(preg_match("/\d{10}/", $num)){
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL,"http://bhashsms.com/api/sendmsg.php");
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, "user=enersyscare&pass=sairaam@5050&sender=EnrSys&phone=".$num."&text=".$msg."&priority=ndnd&stype=normal");
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_exec ($curl);
			curl_close ($curl);
		}
	}
	$msgContent =substr($sContent, 0, 160).'...';
	messageSent(ERROR_NOTIFY_MOBILE,$msgContent);
	messageSent(ERROR_NOTIFY_MOBILE2,$msgContent);
	mail(ERROR_NOTIFY_EMAIL, ERROR_NOTIFY_SUBJECT, $sContent);
}

/** END OF PHPMAILER **/

/**
 * Uncomment this line to use the default PHP mail() function if not using PHPMailer
 */
//mail(ERROR_NOTIFY_EMAIL, ERROR_NOTIFY_SUBJECT, $sContent);

/**
 * Truncate the error log so we don't email it all again on the next run.
 */
//file_put_contents(ERROR_LOG_FILE,null);

/**
 * We'll copy the full content of the error log to an archive. This is useful for a number
 * of reasons, not least because we are only emailing a portion of the original errors if
 * the log file was larger than our given MAX_CONTENT_SIZE - there could be errors in the
 * full log not included in the email.
 */
$sHistoricalLogName = sprintf('%s.archive', ERROR_LOG_FILE);

$sFullContent = sprintf("----- Full content of error log as mailed @ %s -----\n%s\n", date('d/m/Y H:i:s'), $sFullContent);

file_put_contents($sHistoricalLogName, $sFullContent, FILE_APPEND);

/**
 * And we're done.
 */

exit;

?>
