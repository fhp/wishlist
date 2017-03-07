<?php

namespace Wenslijst\Pages;

use Unicorn\UI\Base\Widget;
use Wenslijst\Forms\NewPresentForm;

class AddPresentPage extends WenslijstLayout
{
	function __construct()
	{
		parent::__construct();
		
		$this->setTitle("Wenslijst");
		
		$this->addChild($this->newPresentForm());
	}
	
	private function newPresentForm(): Widget
	{
		return new NewPresentForm("newPresent", route("addPresent"));
	}
}
