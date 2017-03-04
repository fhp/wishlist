<?php
namespace Wenslijst\Forms;

use Unicorn\Forms\Form;
use Unicorn\Forms\HiddenInput;

abstract class CsrfProtectedForm extends Form
{
	protected $csrfFieldName = "_token";
	
	public function __construct($id, $action, $method = "POST", $encoding = "multipart/form-data", $charset = "UTF-8")
	{
		$this->addInput(new HiddenInput($this->csrfFieldName, csrf_token()));
		
		parent::__construct($id, $action, $method, $encoding, $charset);
	}
}
