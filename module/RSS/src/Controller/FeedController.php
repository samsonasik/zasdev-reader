<?php
namespace RSS\Controller;

use RSS\Service\FeedServiceInterface;
use RSS\Service\SubscriptionServiceInterface;
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
     * @var SubscriptionServiceInterface
     */
    protected $subscriptionService;
    /**
     * @var TranslatorInterface
     */
    protected $translator;
    /**
     * @var bool
     */
    protected $verbose;

    public function __construct(
        FeedServiceInterface $feedService,
        SubscriptionServiceInterface $subscriptionService,
        TranslatorInterface $translator
    ) {
        $this->feedService          = $feedService;
        $this->subscriptionService  = $subscriptionService;
        $this->translator           = $translator;
        $this->verbose              = false;
    }

    public function refreshAction()
    {
        $this->verbose = $this->params()->fromRoute('verbose', false) || $this->params()->fromRoute('v', false);
        $this->printMessage($this->translate('Getting feeds from sources...'));

        $subscriptions = $this->subscriptionService->getSubscriptions();
        $this->printVerboseMessage(
            sprintf($this->translate('Found %s subscriptions. Starting to read them.'), count($subscriptions))
        );

        foreach ($subscriptions as $subscription) {
            $this->printVerboseMessage(
                sprintf($this->translate('Reading subscription "%s"...'), $subscription->getName())
            );

            $newEntries = $this->feedService->importNewFeeds($subscription);
            $this->printVerboseMessage(
                '\t' . sprintf($this->translate('Found %s new entries. Saving...'), count($newEntries))
            );
            $this->feedService->saveFeeds($newEntries);
        }

        $this->printMessage($this->translate('New entries properly saved'));
        return PHP_EOL;
    }

    protected function printMessage($message, $color = ColorInterface::LIGHT_BLUE)
    {
        $console = $this->getConsole();
        $console->writeLine($message, $color);
    }

    protected function printVerboseMessage($message, $color = ColorInterface::LIGHT_GREEN)
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
