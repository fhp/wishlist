<?php

namespace Wenslijst\Http;

use Symfony\Component\HttpFoundation\Response;

class PageFlowException extends \Exception
{
	private $response;
	
	public function __construct(Response $response)
	{
		$this->response = $response;
		parent::__construct();
	}
	
	public function response()
	{
		return $this->response;
	}
}
