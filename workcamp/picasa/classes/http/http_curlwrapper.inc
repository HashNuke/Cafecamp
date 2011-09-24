<?php

class http_CurlWrapper {
	const COOKIE_STORAGE_PATH = "/tmp/";
	const COOKIE_JAR_FILE_PREFIX = "cwcj-";
	
	private static $instance = NULL;
	private $curl_handle;
	private $cookie_jar;
	
	private function __construct() {
		$this->curl_handle = curl_init();
		$this->cookie_jar = tempnam(self::COOKIE_STORAGE_PATH, self::COOKIE_JAR_FILE_PREFIX);
		curl_setopt($this->curl_handle, CURLOPT_HEADER, FALSE);
//		curl_setopt($this->curl_handle, CURLOPT_VERBOSE, TRUE);
		curl_setopt($this->curl_handle, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($this->curl_handle, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($this->curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($this->curl_handle, CURLOPT_COOKIEJAR, $this->cookie_jar);
		curl_setopt($this->curl_handle, CURLOPT_COOKIEFILE, $this->cookie_jar);
	}
	
	public function __destruct() {
		if(file_exists($this->cookie_jar)) {
			@unlink($this->cookie_jar);
		}
		curl_close($this->curl_handle);
	}
	
	public function &getInstance() {
		if(is_null(self::$instance)) {
			self::$instance = new http_CurlWrapper();
		}
		return self::$instance;
	}
	
	public function setUserAgent($ua) {
		curl_setopt($this->curl_handle, CURLOPT_USERAGENT, $ua);
	}
	
	public function setCookie($cookie_string) {
		curl_setopt($this->curl_handle, CURLOPT_COOKIE, $cookie_string);
	}
	
	public function setURL($url) {
		curl_setopt($this->curl_handle, CURLOPT_URL, $url);
	}
	
	public function setMethod($method) {
		if(stristr($method, "GET") !== FALSE) {
			curl_setopt($this->curl_handle, CURLOPT_GET, TRUE);
		}
		elseif(stristr($method, "POST") !== FALSE) {
			curl_setopt($this->curl_handle, CURLOPT_POST, TRUE);
		}
		else {
			throw new Exception("Unknown HTTP method requested");
		}
	}
		
	public function setHeader($header = array()) {
		curl_setopt($this->curl_handle, CURLOPT_HTTPHEADER, $header);
	}
	
	public function setPostFields($post_data) {
		curl_setopt($this->curl_handle, CURLOPT_POSTFIELDS, $post_data);
	}
	
	public function execute() {
		$response = curl_exec($this->curl_handle);
		if($this->isError()) {
			throw new HTTPClientException($this->getErrorMsg(), $this->getErrorCode());
		}
		return $response;
	}
	
	public function isError() {
		return (bool) curl_errno($this->curl_handle);
	}
	
	public function getErrorMsg() {
		return curl_error($this->curl_handle);
	}
	
	public function getErrorCode() {
		return curl_errno($this->curl_handle);
	}
}

class HTTPClientException extends Exception
{
	public function __construct($message = "", $code = 0) {
		parent::__construct($message, $code);
	}
} 
 
