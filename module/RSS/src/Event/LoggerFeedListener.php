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

namespace ZasDev\RSS\Event;
use ZasDev\RSS\Entity\FeedEntry;
use Zend\Log\LoggerInterface;

/**
 * Class LoggerFeedListener
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class LoggerFeedListener extends AbstractFeedListener
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Called when some Feeds are imported
     * @param FeedEvent $e
     * @return bool
     */
    public function onFeedsImported(FeedEvent $e)
    {
        $totalFeedEntries = $e->getParam('totalFeedEntries');
        $this->logger->info(sprintf('Imported %s feed entries', $totalFeedEntries));
        return true;
    }

    /**
     * Called when an error occurs while importing feeds
     * @param FeedEVent $e
     * @return bool
     */
    public function onFeedsImportError(FeedEvent $e)
    {
        /** @var \Exception $exception */
        $exception = $e->getParam('exception');
        $this->logger->err(
            'An error occurred while importing feed entries' . PHP_EOL .
            $exception->getMessage() . PHP_EOL . $exception->getTraceAsString()
        );
        return true;
    }

    /**
     * Called when a group of feeds is saved
     * @param FeedEvent $e
     * @return bool
     */
    public function onFeedSaved(FeedEvent $e)
    {
        /** @var FeedEntry $feedEntry */
        $feedEntry = $e->getParam('feedEntry');
        $this->logger->info(sprintf(
            'Saved feed entry with title "%s" from Subscription with name "%s"',
            $feedEntry->getTitle(),
            $feedEntry->getSubscription()->getName()
        ));
        return true;
    }
}
