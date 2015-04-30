<?php

namespace Curl;

/**
 * Request
 * 
 * @author Ing. Miroslav Valerián <info@miroslav-valerian.cz>
 * 
 */

class Request
{
	const GET = 'GET';
	const POST = 'POST';
	
	/** @var string */
	protected $method;
	
	/** @var string */
	protected $url;
	
	/** @var array */
	protected $get = array();
	
	/** @var array */
	protected $post = array();
	
	/** @var int */
	protected $connectionTimeout;
	
	/** @var string */
	protected $userAgent;
	
	public $curl;
	
	/**
	 * 
	 * @param string $url
	 */
	public function __construct($url = null)
	{
		$this->url = $url;		
	}

	/**
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
	}
	
	/**
	 * 
	 * @param string $url
	 * @return \Curl\Request
	 */
	public function setUrl($url)
	{
		$this->url = $url;
		return $this;
	}
	
	/**
	 * 
	 * @return int
	 */
	public function getConnectionTimeout()
	{
		return $this->connectionTimeout;
	}

	/**
	 * 
	 * @param type $timeout
	 * @return \Curl\Request
	 */
	public function setConnectTimeout($timeout)
	{
		$this->connectionTimeout = $timeout;
		return $this;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getUserAgent()
	{
		return $this->userAgent;
	}

	/**
	 * 
	 * @param type $agent
	 * @return \Curl\Request
	 */
	public function setUserAgent($agent)
	{
		$this->userAgent = $agent;
		return $this;
	}
	
	/**
	 * @param array $query
	 *
	 * @return \Curl\Response
	 */
	public function get($query = array())
	{
		$this->method = self::GET;
		$this->get = $query;
		return $this->send();
	}
	
	/**
	 * @param array $query
	 *
	 * @return \Curl\Response
	 */
	public function post($query = array())
	{
		$this->method = self::POST;
		$this->post = $query;
		return $this->send();
	}
	
	/**
	 * @return \Curl\Response
	 * @throws \Curl\CurlException if curl is not instaled
	 */
		
	protected function send()
	{
		if (function_exists('curl_init')) {
			$this->curl = curl_init();
			curl_setopt($this->curl, CURLOPT_URL, $this->url);
			
			if ($this->connectionTimeout) {
				curl_setopt($this->curl,CURLOPT_CONNECTTIMEOUT, $this->connectionTimeout);
			} 
			curl_setopt($this->curl, CURLOPT_HEADER, FALSE);
			curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, FALSE);
			if ($this->userAgent) {
				curl_setopt($this->curl, CURLOPT_USERAGENT, $this->userAgent);		
			}
			if ($this->method == self::POST) {
				curl_setopt($this->curl, CURLOPT_POST,1);
				curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->post);	
			}
			$response = new Response($this);
			return $response;
 		} else {
		 	throw new CurlException("curl_init is not instaled.");
		}
	}
}
