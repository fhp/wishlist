<?php
namespace Wenslijst\Forms;

use Illuminate\Support\Facades\Request;
use Unicorn\Forms\Form;
use Unicorn\Forms\HiddenInput;
use Wenslijst\Http\PageFlowException;

abstract class LaravelForm extends Form
{
	protected $csrfFieldName = "_token";
	
	public function __construct($id, $action = null)
	{
		if($action === null) {
			$action = Request::getRequestUri();
		}
		
		$this->addInput(new HiddenInput($this, $this->csrfFieldName, csrf_token()));
		
		parent::__construct($id, $action);
	}
	
	protected function doRedirect($target)
	{
		throw new PageFlowException(redirect()->away($target));
	}
}
