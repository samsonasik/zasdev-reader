<?php
namespace RSS\Service;

use Doctrine\Common\Persistence\ObjectManager;
use RSS\Entity\FeedEntry;
use RSS\Entity\FeedFolder;
use RSS\Entity\Subscription;
use RSS\Event\FeedEvent;
use RSS\Exception\FeedImportException;
use ZasDev\Common\Service\AbstractService;
use Zend\Authentication\AuthenticationService;
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
    public function __construct(ObjectManager $objectManager, AuthenticationService $authService)
    {
        parent::__construct($objectManager, $authService);
    }

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
            $this->saveFeed($feed);
        }
    }

    /**
     * Saves defined FeedEntry
     * @param FeedEntry $feed
     * @return $this
     */
    public function saveFeed(FeedEntry $feed)
    {
        // TODO: Implement saveFeed() method.
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
        // TODO: Implement getUnreadFeeds() method.
    }

    /**
     * Returns a list of starred Feeds
     * @param Subscription|FeedFolder $container The Subscription or FeedFolder containing feeds
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    public function getStarredFeeds($container = null, $limit = 20, $offset = 0)
    {
        // TODO: Implement getStarredFeeds() method.
    }

    private function createFeedEvent($name)
    {
        $e = new FeedEvent($this, $name);
        return $e;
    }
}
