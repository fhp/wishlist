<?php
namespace Wenslijst\Forms;

use Illuminate\Support\Facades\Request;
use Unicorn\Forms\Form;
use Unicorn\Forms\HiddenInput;

abstract class LaravelForm extends Form
{
	protected $csrfFieldName = "_token";
	
	public function __construct($id, $action = null, $method = "POST", $encoding = "multipart/form-data", $charset = "UTF-8")
	{
		if($action === null) {
			$action = Request::getRequestUri();
		}
		
		$this->addInput(new HiddenInput($this->csrfFieldName, csrf_token()));
		
		parent::__construct($id, $action, $method, $encoding, $charset);
	}
}
