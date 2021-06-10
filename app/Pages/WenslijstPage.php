<?php

namespace Wenslijst\Pages;

use Unicorn\UI\Base\HtmlElement;
use Unicorn\UI\Base\Widget;
use Unicorn\UI\Bootstrap\Alert;
use Unicorn\UI\Bootstrap\ContextualStyle;
use Unicorn\UI\Bootstrap\ModalForm;
use Unicorn\UI\Bootstrap\OrmTable;
use Unicorn\UI\HTML\Header;
use Unicorn\UI\HTML\Link;
use Unicorn\UI\HTML\Paragraph;
use Wenslijst\Forms\ClaimPresentForm;
use Wenslijst\Present;
use Wenslijst\Forms\NewPresentForm;
use Wenslijst\UI\ShoppingcartIcon;

class WenslijstPage extends WenslijstLayout
{
	function __construct()
	{
		parent::__construct();
		
		$this->setTitle("Boodschappen registratie");
		
		$this->addChild(new Header("Boodschappen", "h1", "Deze boodschappen kunnen we nog goed gebruiken op kamp"));
		$this->addChild(new Alert("Uitleg:", "Hieronder staat een lijst met boodschappen die we goed kunnen gebruiken op het kamp. Als je een van deze spullen mee wilt nemen, claim deze dan door op de knop rechts te klikken zodat anderen dat ook niet kopen.", ContextualStyle::info()));
		$this->addChild($this->presentsList());
		$this->addChild($this->newPresentForm());
	}
	
	private function presentsList(): Widget
	{
		$presents = Present::all();
		if($presents->count() == 0) {
			return new Alert("Helaas:", "Momenteel is de lijst met boodschappen leeg.", ContextualStyle::warning());
		}
		$table = new OrmTable($presents);
		$table->addColumnFunction("Product", function(Present $present) {
			if($present->url === null) {
				return $present->name;
			} else {
				$link = new Link($present->url);
				$link->openInNewPage();
				$link->addText($present->name);
				return $link;
			}
		});
		$table->addColumnFunction("Details", function(Present $present) { return $present->omschrijving; });
		$table->addColumnFunction("Claim", function(Present $present) {
			$modal = new ModalForm(new ClaimPresentForm($present));
			$modal->includeToggleButton("Neem ik mee", new ShoppingcartIcon());
			$modal->addCloseButton("Ik denk er nog even over na");
			return $modal;
		});
		
		return $table;
	}
	
	private function newPresentForm(): Widget
	{
		return new NewPresentForm("newPresent");
	}
}
