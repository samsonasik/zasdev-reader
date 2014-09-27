<?php
namespace RSS\Controller;

use RSS\Service\FeedServiceInterface;
use Zend\Console\ColorInterface;
use Zend\I18n\Translator\TranslatorInterface;
use Zend\Mvc\Controller\AbstractConsoleController;

/**
 * Class FeedController
 * @author ZasDev
 * @link
 */
class FeedController extends AbstractConsoleController
{
    /**
     * @var FeedServiceInterface
     */
    protected $feedService;
    /**
     * @var TranslatorInterface
     */
    protected $translator;
    /**
     * @var bool
     */
    protected $verbose;

    public function __construct(FeedServiceInterface $feedService, TranslatorInterface $translator)
    {
        $this->feedService  = $feedService;
        $this->translator   = $translator;
        $this->verbose      = false;
    }

    public function refreshAction()
    {
        $this->verbose = $this->params()->fromRoute('verbose', false) || $this->params()->fromRoute('v', false);

        $this->printMessage($this->translate('Getting feeds from sources...'), ColorInterface::LIGHT_BLUE);


        $this->printMessage($this->translate('DONE'));

        return PHP_EOL;
    }

    protected function printMessage($message, $color = null)
    {
        $console = $this->getConsole();
        $console->writeLine($message, $color);
    }

    protected function printVerboseMessage($message, $color = null)
    {
        if (!$this->verbose) {
            return;
        }

        $this->printMessage($message, $color);
    }

    /**
     * @param string $message
     * @return string
     */
    protected function translate($message)
    {
        return $this->translator->translate($message);
    }
}
