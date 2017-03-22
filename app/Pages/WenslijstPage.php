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
use Wenslijst\Forms\DeletePresentForm;
use Wenslijst\Forms\RSVPForm;
use Wenslijst\Present;
use Wenslijst\Forms\NewPresentForm;
use Wenslijst\UI\PresentIcon;

class WenslijstPage extends WenslijstLayout
{
	function __construct()
	{
		parent::__construct();
		
		$this->setTitle("RSVP & Wenslijst");
		
		$rsvpForm = new RSVPForm("rsvp");
		if($rsvpForm->checkAccess()) {
			$legend = new HtmlElement("legend");
			$legend->addChild(new Header("Ben je er bij?", "h1", "Vinden we fijn om te weten :)"));
			$this->addChild($legend);
			$this->addChild($rsvpForm);
			$this->addChild(new HtmlElement("hr"));
		}
		
		$this->addChild(new Header("Wenslijst", "h1", "Ideeën voor Jace, Nadine en/of Stef"));
		$this->addChild(new Alert("Uitleg:", "Hieronder staat een lijst met cadeau's die wij leuk vinden, die je als inspiratie kan gebruiken. Als er iets tussenstaat wat je wilt geven, claim deze dan door op de knop rechts te klikken zodat anderen dat ook niet kopen.", ContextualStyle::info()));
		$this->addChild($this->presentsList());
		$this->addChild($this->newPresentForm());
	}
	
	private function presentsList(): Widget
	{
		$presents = Present::all();
		if($presents->count() == 0) {
			return new Alert("Helaas:", "Momenteel is de lijst met ideeen leeg :( Het is mogelijk dat een grapjas alles heeft geclaimed, probeer het binnenkort nog eens of neem rechtstreeks contact met ons op.", ContextualStyle::warning());
		}
		$table = new OrmTable($presents);
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
			$modal = new ModalForm(new DeletePresentForm($present));
			$modal->includeToggleButton("Deze claim ik", new PresentIcon());
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
