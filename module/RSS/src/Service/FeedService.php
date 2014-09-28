<?php
namespace RSS\Service;

use RSS\Entity\FeedEntry;
use RSS\Entity\FeedFolder;
use RSS\Entity\Subscription;
use RSS\Event\FeedEvent;
use RSS\Exception\FeedImportException;
use RSS\Exception\FeedSaveException;
use RSS\Repository\FeedEntryInterface;
use ZasDev\Common\Service\AbstractService;
use Zend\Feed\Reader\Entry\AbstractEntry;
use Zend\Feed\Reader\Reader as FeedReader;
use Zend\Http\Client\Adapter\AdapterInterface as HttpAdapter;

/**
 * Class FeedService
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class FeedService extends AbstractService implements FeedServiceInterface
{
    /**
     * Reads defined subscription looking for new feeds. This could be a time consuming task
     * @param Subscription $subscription
     * @param HttpAdapter $httpAdapter
     * @return FeedEntry[]
     * @throws FeedImportException In case an error occurs while importing Feeds
     */
    public function importNewFeeds(Subscription $subscription, HttpAdapter $httpAdapter = null)
    {
        // Retrieve feeds from remote host. If defined use a custom HttpAdapter
        if (isset($httpAdapter)) {
            FeedReader::getHttpClient()->setAdapter($httpAdapter);
        }

        $feedEntries = array();
        try {
            $channel = FeedReader::import($subscription->getUrl());
            /* @var AbstractEntry $remoteEntry */
            foreach ($channel as $remoteEntry) {
                $entry = new FeedEntry();
                $feedEntries[] = $entry->exchangeRssEntry($remoteEntry);
            }

            $this->getEventManager()->trigger($this->createFeedEvent(FeedEvent::EVENT_FEEDS_IMPORTED));
        } catch (\Exception $e) {
            $this->getEventManager()->trigger($this->createFeedEvent(FeedEvent::EVENT_FEEDS_IMPORT_ERROR));
            throw new FeedImportException($subscription->getUrl(), $e);
        }

        return $feedEntries;
    }

    /**
     * Saves the list of feeds
     * @param FeedEntry[] $feeds
     * @return $this
     */
    public function saveFeeds(array $feeds)
    {
        foreach ($feeds as $feed) {
            $this->saveFeed($feed, false);
        }
        return $this->flush();
    }

    /**
     * Saves defined FeedEntry
     * @param FeedEntry $feed
     * @param bool $flush
     * @throws FeedSaveException
     * @return $this
     */
    public function saveFeed(FeedEntry $feed, $flush = true)
    {
        try {
            $this->getObjectManager()->persist($feed);
            $this->getEventManager()->trigger($this->createFeedEvent(
                FeedEvent::EVENT_FEED_SAVED,
                array('feedEntry' => $feed)
            ));
            return $this->flush($flush);
        } catch (\Exception $e) {
            throw new FeedSaveException($feed->getUuid());
        }
    }

    /**
     * Returns a list of unread feeds
     * @param Subscription|FeedFolder $container The Subscription or FeedFolder containing feeds
     * @param int $limit
     * @param int $offset
     * @return FeedEntry[]
     */
    public function getUnreadFeeds($container = null, $limit = 20, $offset = 0)
    {
        /** @var FeedEntryInterface $repo */
        $repo = $this->getObjectManager()->getRepository(FeedEntry::_CLASS);
        return $repo->findUnreadFeeds($container, $limit, $offset);
    }

    /**
     * Returns a list of starred Feeds
     * @param Subscription|FeedFolder $container The Subscription or FeedFolder containing feeds
     * @param int $limit
     * @param int $offset
     * @return FeedEntry[]
     */
    public function getStarredFeeds($container = null, $limit = 20, $offset = 0)
    {
        /** @var FeedEntryInterface $repo */
        $repo = $this->getObjectManager()->getRepository(FeedEntry::_CLASS);
        return $repo->findStarredFeeds($container, $limit, $offset);
    }

    /**
     * @param $name
     * @param array $params
     * @return FeedEvent
     */
    private function createFeedEvent($name, array $params = array())
    {
        return new FeedEvent($this, $name, $params);
    }

    /**
     * Flushes wraped ObjectManager if defined
     * @param bool $flush
     * @return $this
     */
    private function flush($flush = true)
    {
        if ($flush) {
            $this->objectManager->flush();
        }
        return $this;
    }
}
