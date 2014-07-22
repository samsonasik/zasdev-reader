<?php
namespace Application\Controller;

use Application\Util\AppData;
use Zend\Console\Adapter\AdapterInterface;
use Zend\Console\ColorInterface;
use Zend\Mvc\Controller\AbstractConsoleController;

/**
 * Class ConsoleController
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class ConsoleController extends AbstractConsoleController
{
    /**
     * @var AdapterInterface
     */
    protected $console;

    public function __construct(AdapterInterface $console)
    {
        $this->console = $console;
    }

    public function versionAction()
    {
        $this->console->write(AppData::APP_VERSION . PHP_EOL, ColorInterface::LIGHT_GREEN);
    }
}
