<?php
/*
 * This file is part of ZasDev Reader.
 *
 * ZasDev Reader is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ZasDev Reader is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ZasDev Reader. If not, see <http://www.gnu.org/licenses/>.
 */

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
