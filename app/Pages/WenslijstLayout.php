<?php

namespace Wenslijst\Pages;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Unicorn\UI\Base\HtmlBlob;
use Unicorn\UI\Base\HtmlElement;
use Unicorn\UI\Bootstrap\BootstrapHtmlPage;
use Unicorn\UI\Bootstrap\LinkButton;
use Unicorn\UI\Bootstrap\Navbar;
use Unicorn\UI\Base\Container;
use Unicorn\UI\Base\Text;
use Unicorn\UI\HTML\Header;
use Unicorn\UI\HTML\Image;

abstract class WenslijstLayout extends BootstrapHtmlPage
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
			$bar->addButton(new LinkButton(route("shoppingList"), "booschappen"), true);
		} else {
			$bar->addButton(new LinkButton(route("login"), "login"), true);
		}
		$this->body()->addChild($bar);
		
		$this->body()->addChild($content);
		
		$this->addStylesheet("css/wenslijst.css");
		
		if(($message = Session::get("message")) !== null) {
			$content->addChild(new HtmlBlob($message));
		}
	}
}
