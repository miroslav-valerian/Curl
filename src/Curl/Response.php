<?php

namespace Curl;

/**
 * Response
 * 
 * @author Ing. Miroslav Valerián <info@miroslav-valerian.cz>
 * 
 */

class Response
{
	protected $request;
	
	public function __construct(Request $request)
	{
    	$this->request = $request;
		
	}
	
	public function getHttpCode()
	{
		$httpcode = @curl_getinfo($this->request->curl, CURLINFO_HTTP_CODE);
		return $httpcode;
	}
	
	public function getHeaders()
	{
		return @curl_getinfo($this->request->curl);
	}
	
	public function getResponse()
	{
		$result = curl_exec($this->request->curl);
		return $result;
	}
}
