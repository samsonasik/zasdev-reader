<?php
namespace RSS\Controller;

use Zend\Mvc\Controller\AbstractConsoleController;

/**
 * Class FeedController
 * @author ZasDev
 * @link
 */
class FeedController extends AbstractConsoleController
{
    public function refreshAction()
    {
        $verbose = $this->params()->fromRoute('verbose') || $this->params()->fromRoute('v');
        return PHP_EOL;
    }
}
