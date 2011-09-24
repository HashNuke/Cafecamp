<?php

class google_ClientLogin
{
	const AUTH_URL = "https://www.google.com/accounts/ClientLogin?service=lh2&Email=%s&Passwd=%s";
	
	private $username;
	private $password;
	private $curl;
	
	private $sid;
	private $lsid;
	private $auth;
	
	public function __construct($username, $password) {
		$this->username = $username;
		$this->password = $password;
		$this->curl = http_CurlWrapper::getInstance();
	}
	
	public function login() {
		$url = sprintf(self::AUTH_URL, $this->username, $this->password);
		$this->curl->setUserAgent("Picasa/32.00998");
		$this->curl->setURL($url);
		$this->curl->setMethod("GET");
		
		$response = $this->curl->execute();
		
		$matches = array();
		preg_match("/SID=(\S+)\nLSID=(\S+)\nAuth=(\S+)/i", $response, $matches);
		
		if(count($matches) == 4) {
			$this->sid = $matches[1];
			$this->lsid = $matches[2];
			$this->auth = $matches[3];
		}
		else {
			throw new GoogleClientLoginException($response);
		}
	}
	
	public function getSID() {
		return $this->sid;
	}
	
	public function getLSID() {
		return $this->lsid;
	}
	
	public function getAuth() {
		return $this->auth;
	}
	
	public function getLoginUser() {
		return $this->username . "@gmail.com";
	}
}

class GoogleClientLoginException extends Exception
{
	public function __construct($message = "", $code = 0) {
		parent::__construct($message, $code);
	}
}