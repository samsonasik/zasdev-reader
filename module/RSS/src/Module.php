<?php
namespace RSS;

use Zend\Console\Adapter\AdapterInterface;
use Zend\Http\Response;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;

/**
 * Class Module
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class Module implements
    ConfigProviderInterface,
    ConsoleUsageProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getConsoleUsage(AdapterInterface $console)
    {
        return array(
            'zdr feeds --refresh [-v|--verbose]' => 'Looks for new feeds in all the subscriptions and downloads them'
        );
    }
}
