<?php

namespace Wenslijst\Pages;

use Illuminate\Support\Facades\Auth;
use Unicorn\UI\Base\HtmlElement;
use Unicorn\UI\Bootstrap\BootstrapHtmlPage;
use Unicorn\UI\Bootstrap\LinkButton;
use Unicorn\UI\Bootstrap\Navbar;
use Unicorn\UI\HTML\Header;
use Unicorn\UI\HTML\Image;

class WenslijstLayout extends BootstrapHtmlPage
{
	function __construct()
	{
		$content = new HtmlElement("div");
		$content->addClass("container");
		
		parent::__construct($content);
		
		$bar = new Navbar();
		$bar->brandLink(new Image("img/logo.png"), route("home"));
		if(Auth::check()) {
			$bar->addButton(new LinkButton(route("logout"), "logout"), true);
		} else {
			$bar->addButton(new LinkButton(route("login"), "login"), true);
		}
		$this->body()->addChild($bar);
		
		$this->body()->addChild($content);
		
		$this->addStylesheet("css/wenslijst.css");
		
		$this->addChild(new Header("Wenslijst", "h1", "Ideeën voor Jace, Nadine en/of Stef"));
	}
	
	protected function setTitle(string $title): void
	{
		parent::setTitle("Test - " . $title);
	}
	
	protected function lipsum(): string
	{
		return file_get_contents("http://loripsum.net/api/1/plaintext");
	}
}
