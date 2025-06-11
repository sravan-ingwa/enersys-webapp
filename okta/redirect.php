<?php

include('../services/mysql.php');
include('../services/functions.php');

class OktaResponse {
	
	public $error = true;	
	public $errorCode = "UNK";
	public $errorMessage = "Unknown Error. Please contact administrator";
	public $token;
    public $accessToken;
    public $tokenInserted = false;
	public $emailId;
}

class OktaAuthentication {
	
	public $oktaUrl = "https://enersys-apac.oktapreview.com/oauth2/default/v1";
    public $mrCon;
    public $token;
    public $accessToken;
	public $tokenType;

    public function __construct($oktaUrl, $mrCon, $token, $accessToken, $tokenType) {
        $this->oktaUrl = $oktaUrl;
        $this->mrCon = $mrCon;
        $this->token = $token;
        $this->accessToken = $accessToken;
		$this->tokenType = $tokenType;
    }

    public function getUserDetails() {
		
		$reqUrl = $this->oktaUrl . "/userinfo";		
		$handle = curl_init();
		$postData = array();
		$header = array();
		$header[] = 'Content-type: application/json';
		$header[] = 'Authorization: ' . $this->tokenType . '' . $this->accessToken;

		curl_setopt($handle, CURLOPT_URL,$reqUrl); 
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($handle, CURLOPT_TIMEOUT, 60); 
		curl_setopt($handle, CURLOPT_HTTPHEADER, $header); 
		curl_setopt($handle, CURLOPT_POST, true); 
        curl_setopt($handle, CURLOPT_POSTFIELDS, $postData); 

		$data = curl_exec($handle);
		
		$response = new OktaResponse();
		if (curl_errno($handle)) { 
            $error = curl_error($handle);
        } else {
			$dataObj = json_decode($data);
			if(isset($dataObj->email)) {
				$response->error = false;
				$response->emailId = $dataObj->email;
				$response->token = $this->token;
				$response->accessToken = $this->accessToken;
                $response->tokenInserted = $this->generateToken($dataObj->email);
                if(!$response->tokenInserted) {
                    $response->error = true;
                    $response->errorMessage = "Credentials are not linked with this application. Please contact administrator.";
                }
			}
            curl_close($handle); 
        }
		return $response;
    }

    function generateToken($emailId) {

        $eType = 0;
        $emailId = strtolower($emailId);
        $eAlias = aliasFlag0($emailId, 'ec_employee_master', 'email_id', 'employee_alias');
        $eName = "";
        if($eAlias) {
            $eType = 1;
            $eName = aliasFlag0($emailId, 'ec_employee_master', 'lower(email_id)', 'name');
        }
        else {
            $eAlias = aliasFlag0($emailId, 'ec_admin', 'lower(email_id)', 'user_name');
            if($eAlias) {
                $eName = $eAlias;
            }
            /* 
            else {
                $eAlias = aliasFlag0($emailId, 'ec_esca', 'lower(esca_email)', 'esca_alias');
                if($eAlias) {
                    $eName = aliasFlag0($emailId, 'ec_esca', 'lower(esca_email)', 'esca_name');
                } else {
                    $eAlias = aliasFlag0($emailId, 'ec_customer', 'lower(customer_email)', 'customer_alias');
                    if($eAlias) {
                        $eName = aliasFlag0($emailId, 'ec_customer', 'lower(customer_email)', 'customer_name');
                    }
                }
            }
            */
        }
        if(!$eAlias) {
            return false;
        }
        $query = "INSERT INTO ec_token(employee_alias, employee_name, employee_type, access_token, token, created_date) VALUES('$eAlias', '$eName', '$eType', '". $this->accessToken ."', '". $this->token ."','".date('Y-m-d')."')";
        $action = $eName." loggedin";
        user_history($eAlias, $action, $_REQUEST['ip_addr']);
        $sql = mysqli_query($this->mrCon, $query);
        return $sql ? $this->token : false;
    }
}

global $mr_con;
global $oktaPreviewUrl;
global $oktaBaseUrl;
if(isset($_REQUEST['error'])) {
	$oktaResp = new OktaResponse();
	$oktaResp->errorCode = $_REQUEST['error'];
	$oktaResp->errorMessage = $_REQUEST['error_description'];
    header('Location: '. $oktaBaseUrl .'/#/signin/fail/' . $oktaResp->errorMessage);
	exit;
} else {
    $token = aliasCheck(generateRandomString(), 'ec_token', 'token');
	$accessToken = $_REQUEST['access_token'];
	$tokenType = $_REQUEST['token_type'];
	$okatObj = new OktaAuthentication($oktaPreviewUrl, $mr_con, $token, $accessToken, $tokenType);
    $oktaResp = $okatObj->getUserDetails();
    if($oktaResp->tokenInserted) {
        header('Location: '. $oktaBaseUrl .'/#/signin-redirect/' . $token);
    } else {
        header('Location: '. $oktaBaseUrl .'/#/signin/fail/' . $oktaResp->errorMessage);
    }
	exit;
}