<?php

namespace Wenslijst\Pages;

use Unicorn\UI\Base\Widget;
use Unicorn\UI\Bootstrap\ModalForm;
use Unicorn\UI\Bootstrap\OrmTable;
use Unicorn\UI\HTML\Link;
use Wenslijst\Forms\DeletePresentForm;
use Wenslijst\Present;
use Wenslijst\Forms\NewPresentForm;
use Wenslijst\UI\PresentIcon;

class WenslijstPage extends WenslijstLayout
{
	function __construct()
	{
		parent::__construct();
		
		$this->setTitle("Wenslijst");
		
		$this->addChild($this->presentsList());
		$this->addChild($this->newPresentForm());
	}
	
	private function presentsList(): Widget
	{
		$table = new OrmTable(Present::all());
		$table->addColumnFunction("Cadeau", function(Present $present) {
			if($present->url === null) {
				return $present->name;
			} else {
				$link = new Link($present->url);
				$link->openInNewPage();
				$link->addText($present->name);
				return $link;
			}
		});
		$table->addColumnFunction("Voor wie?", function(Present $present) { return $present->ontvanger; });
		$table->addColumnFunction("Details", function(Present $present) { return $present->omschrijving; });
		$table->addColumnFunction("Claim", function(Present $present) {
			$modal = new ModalForm(new DeletePresentForm($present, ""));
			$modal->includeToggleButton(null, new PresentIcon());
			$modal->addCloseButton("Ik denk er nog even over na");
			return $modal;
		});
		
		return $table;
	}
	
	private function newPresentForm(): Widget
	{
		return new NewPresentForm("newPresent", "");
	}
}
