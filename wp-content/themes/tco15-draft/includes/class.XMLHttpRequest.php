<?php
/**
 * Class XMLHttpRequest (PHP 5 only)
 * Easiest way of using PHP cURL library, it's uses "XMLHttpRequest" syntax to work with cURL.
 *
 * @version 1.03 2009-06-26T11:00-45:00
 * @author Moises Lima <mozlima@hotmail.com>
 * @link http://www.moonlight21.com/class-XMLHttpRequest-php Comments & suggestions
 * @link http://www.moonlight21.com/class-XMLHttpRequest-php Available at
 */
 
/*
 * Copyright (C) 2009  Moises Lima
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

class XMLHttpRequest
{
	/**
	*	@access private
	*/
	private $curl;
	private $responseHeaders;
	private $headers;
	private $is_safe_mode = true;
	private $properties = array();
	/**
	*	@access private
	*/
	public function __set($property, $value) {
		switch (strtolower($property)) {
			case "maxredirects":
				if(is_int($value)) {
					$this->properties["maxredirects"] = $value;
				}else{
					throw new Exception("cannot implicitly convert type in the property \"$property\" to int");
				}
				break;
			case "curl":
			case "error":
			case "readystate":
			case "responsetext":
			case "responsexml":
			case "status":
			case "statustext":
				throw new Exception("property \"$property\" cannot be assigned to -- it is read only");
				break;
			default:
				throw new Exception("class \"".__CLASS__."\" does not contain a definition for \"$property\"");
		}
	}
	/**
	*	@access private
	*/
  public function __get($property) {
		switch (strtolower($property)){
			case "curl":
				return $this->curl;
			case "error":
				return curl_error($this->curl);
			case "maxredirects":
			case "readystate":
			case "responsetext":
			case "status":
			case "statustext":
				$property = strtolower($property);
				if(isset($this->properties[$property])){
					return $this->properties[$property];
				}else return null;
			case "responsexml":
				if(!isset($this->properties["responsexml"])){
					if(isset($this->properties["responsetext"]) && !empty($this->properties["responsetext"])){
						$xml = DOMDocument::loadXML($this->properties["responsetext"], LIBXML_ERR_NONE | LIBXML_NOERROR);
						if($xml){
							$this->properties["responsexml"] = $xml;
							return $xml;
						}
					}
				}else{
					return $this->properties["responsexml"];
				}
				return null;
			default:
				throw new Exception("class \"".__CLASS__."\" does not contain a definition for \"$property\"");
		}
  }
	/**
	* Class constructor.
	* Initializes a new instance of the class.
	*/
	public function __construct(){
		if(function_exists("curl_init")){
			$this->is_safe_mode = ini_get('safe_mode');
			$this->curl = curl_init();
			if(isset($_SERVER['HTTP_USER_AGENT'])){
				curl_setopt($this->curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );
			}else{
				curl_setopt($this->curl, CURLOPT_USERAGENT, "XMLHttpRequest/1.0");
			}
			curl_setopt($this->curl, CURLOPT_HEADER, true);
			curl_setopt($this->curl, CURLOPT_AUTOREFERER, true);
			curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
		}else{
			throw new Exception("Could not initialize cURL library");
		}
	}
	/**
	* Class destructor.
	* Closes the cURL session and frees all resources.
	*/
	public function __destruct() {
		curl_close($this->curl);
	}
	/** 
	*	Returns a String that represents the current Object.
	*	@access public
	*	@return string A string that represents the current Object.
	*/
	public function __toString(){
		return __CLASS__;
	}
	/** 
	*	Specifies the method, URL, and other optional attributes of a request.
	*	@access public 
	*	@link http://www.w3.org/TR/XMLHttpRequest/#dfn-open
	*	@param String $method HTTP Methods defined in section 5.1.1 of RFC 2616 http://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html
	*	@param String $url Specifies either the absolute or a relative URL of the data on the Web service.
	*	@param Bolean $async FakeSauro Erectus...
	*	@param String $user specifies the name of the user for HTTP authentication.
	*	@param String $password specifies the password of the user for HTTP authentication.
	*	@return void 
	*/
	public function open($method, $url, $async = false, $user = "", $password = ""){
		$this->properties = array("readystate" => 0);
		$this->responseHeaders;
		$this->headers = array();
		
		if(!empty($method) && !empty($url)){
			$method = strtoupper(trim($method));
			if(!@ereg("^(GET|POST|HEAD|TRACE|PUT|DELETE|OPTIONS)$", $method)){
				throw new Exception("Unknown HTTP method \"$method\"");
			}
			$referer = curl_getinfo($this->curl, CURLINFO_EFFECTIVE_URL);
			if(!empty($referer) ){
				curl_setopt($this->curl, CURLOPT_REFERER, $referer);
			}elseif(isset($_SERVER['HTTP_REFERER'])){
				curl_setopt($this->curl, CURLOPT_REFERER, $_SERVER['HTTP_REFERER']);
			}
			curl_setopt($this->curl, CURLOPT_URL, $url);
			if($method == "POST"){
				curl_setopt($this->curl, CURLOPT_POST, 1);
			}elseif($method == "GET"){
				curl_setopt($this->curl, CURLOPT_POST, 0);
			}else{
				curl_setopt($this->curl, CURLOPT_POST, 0);
				curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $method); 
			}
			if(@ereg("^(https)", $url)){
				curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
			}
			if(!empty($user)){
				curl_setopt($this->curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
				curl_setopt($this->curl, CURLOPT_USERPWD, $user.":". $password);
			}
		}
	}
	/** 
	*	Assigns a label/value pair to the header to be sent with a request.
	*	@access public 
	*	@link http://www.w3.org/TR/XMLHttpRequest/#dfn-setrequestheader
	*	@param String $label Specifies the header label.
	*	@param String $value Specifies the header value.
	*	@return void 
	*/
	public function setRequestHeader($label, $value){
		$this->headers[] = "$label: $value";
		curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->headers);
	}
	/** 
	*	Returns complete set of headers (labels and values) as a string.
	*	@access public 
	*	@link http://www.w3.org/TR/XMLHttpRequest/#dfn-getallresponseheaders
	*	@return string Complete set of headers (labels and values) as a string 
	*/
	public function getAllResponseHeaders(){
		return $this->responseHeaders;
	}
	/** 
	*	Returns the value of the specified http header.
	*	@access public 
	*	@link http://www.w3.org/TR/XMLHttpRequest/#dfn-getresponseheader.
	*	@param String $label
	*	@return String|null The string value of a single header label.
	*/ 
	public function getResponseHeader($label){
		$value = array();
		//preg_match_all('/(?s)'.$label.': (.*?)\r\n/i', $this->responseHeaders, $value);
		preg_match_all('/^(?s)'.$label.': (.*?)\r\n/im', $this->responseHeaders, $value);
		if(count($value ) > 0){
			return implode(', ', $value[1]);
		}
		return null;
	}
	/** 
	*	Transmits the request, optionally with postable string or DOM object data.
	*	@access public 
	*	@link http://www.w3.org/TR/XMLHttpRequest/#dfn-getresponseheader
	*	@param String $data
	*	@return void
	*/
	public function send($data=null){
		if($data){
			curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
		}
		if(isset($this->properties["maxredirects"]) && $this->properties["maxredirects"] && !$this->is_safe_mode){
			if(is_int($this->properties["maxredirects"])){
				curl_setopt($this->curl, CURLOPT_MAXREDIRS, $this->properties["maxredirects"]);
				curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, true);
			}else trigger_error("cannot implicitly convert type in the property \"maxRedirects\" to int",E_USER_WARNING);
		}
		
		$response = curl_exec($this->curl);
		$header_size = curl_getinfo($this->curl, CURLINFO_HEADER_SIZE);
		$raw_header  = substr($response, 0, $header_size - 4);
		$headerArray = explode("\r\n\r\n", $raw_header);
		$header = $headerArray[count($headerArray) - 1];
		
		if(isset($this->properties["maxredirects"]) && $this->properties["maxredirects"] && $this->is_safe_mode){
			if(is_int($this->properties["maxredirects"])){
				$location = array();
				$count = 0;
				while(preg_match('/Location:(.*?)\s\n/im', $header, $location) && ( $count <= $this->properties["maxredirects"])){
					$count++;
					$referer = curl_getinfo($this->curl, CURLINFO_EFFECTIVE_URL);
					$location = parse_url(trim(array_pop($location)));
					$last_url = parse_url($referer);
					if (!isset($location['scheme']))$location['scheme'] = $last_url['scheme'];
					if (!isset($location['host']))$location['host'] = $last_url['host'];
					if (!isset($location['path']))$location['path'] = $last_url['path'];
					$next_url = $location['scheme'] . '://' . $location['host'] . $location['path'] . (isset($location['query'])?'?'.$location['query']:'');
					curl_setopt($this->curl, CURLOPT_POST, 0);
					curl_setopt($this->curl,  CURLOPT_REFERER, $referer);
					curl_setopt($this->curl, CURLOPT_URL, $next_url);
					
					$response = curl_exec($this->curl);
					$header_size = curl_getinfo($this->curl, CURLINFO_HEADER_SIZE);
					$raw_header  = substr($response, 0, $header_size - 4);
					$headerArray = explode("\r\n\r\n", $raw_header);
					$header = $headerArray[count($headerArray) - 1];
				}
			}else trigger_error("cannot implicitly convert type in the property \"maxRedirects\" to int",E_USER_WARNING);
		}
		$this->properties["responsetext"] = substr($response, $header_size);
		$sT = array();
		preg_match('/^HTTP\/\d\.\d\s+(\d{3}) (.*)\s\n/i',$header ,$sT);
		if(count($sT ) > 2){
			$this->responseHeaders = @ereg_replace ($sT[0],"",$header)."\r\n\r\n";
			$this->properties["status"] = $sT[1];
			$this->properties["statustext"] = $sT[2];
		}
		$this->properties["readystate"] = 4;
	}
}
?>
