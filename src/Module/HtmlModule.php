<?php
namespace Nielsen\SelectRunner\Module;

use Madapaja\TwigModule\TwigErrorPageModule;
use Madapaja\TwigModule\TwigModule;
use Ray\Di\AbstractModule;

class HtmlModule extends AbstractModule
{
    protected function configure()
    {
        $this->install(new TwigModule);
        $this->install(new TwigErrorPageModule);
    }
}
