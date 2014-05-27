<?php
namespace ZasDev\Ajax;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

/**
 * Class Module
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class Module implements BootstrapListenerInterface,
                        ConfigProviderInterface,
                        AutoloaderProviderInterface
{

    /**
     * Listen to the bootstrap event
     *
     * @param EventInterface $e
     * @return array
     */
    public function onBootstrap(EventInterface $e)
    {
        /* @var MvcEvent $e */
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this, "ajaxOpperations"), -10);
        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, "ajaxOpperations"), -10);
    }

    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return array();
    }

    /**
     * Return an array for passing to Zend\Loader\AutoloaderFactory.
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace("\\", "/", __NAMESPACE__),
                ),
            ),
        );
    }

    /**
     * This is called after the action is executed
     * @param MvcEvent $e
     */
    public function ajaxOpperations(MvcEvent $e) {
        $model = $e->getResult();
        // Disable layout on Ajax requests
        if ($model instanceof ViewModel && !($model instanceof JsonModel)) {
            $model->setTerminal($e->getRequest()->isXmlHttpRequest());
        }
    }

}