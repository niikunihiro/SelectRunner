<?php
namespace Nielsen\SelectRunner\Module;

use BEAR\Package\AbstractAppModule;
use BEAR\Package\PackageModule;
use BEAR\Package\Provide\Router\AuraRouterModule;
use Koriym\DbAppPackage\DbAppPackage;
use Nielsen\SelectRunner\Form\QueryForm;
use Ray\Di\Scope;
use Ray\WebFormModule\AuraInputModule;
use Ray\WebFormModule\FormInterface;
use SqlFormatter;

class AppModule extends AbstractAppModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $appDir = $this->appMeta->appDir;
        require_once $appDir . '/env.php';
        $this->install(new AuraRouterModule($appDir . '/var/conf/aura.route.php'));
        $this->install(new DbAppPackage(getenv('DB_DSN'), getenv('DB_USER'), getenv('DB_PASS'), getenv('DB_READ')));
        $this->bind(SqlFormatter::class);
        $this->install(new AuraInputModule);
        $this->bind(FormInterface::class)->annotatedWith('query_form')->to(QueryForm::class);
        $this->install(new PackageModule);
    }
}
