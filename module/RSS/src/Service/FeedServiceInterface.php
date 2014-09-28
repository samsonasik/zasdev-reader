<?php
namespace RSS\Service;

use RSS\Entity\FeedEntry;
use RSS\Entity\FeedFolder;
use RSS\Entity\Subscription;
use RSS\Exception\FeedImportException;
use Zend\Http\Client\Adapter\AdapterInterface as HttpAdapter;

/**
 * Interface FeedServiceInterface
 * @author ZasDev
 * @link https://github.com/zasDev
 */
interface FeedServiceInterface
{
    /**
     * Reads defined subscription looking for new feeds. This could be a time consuming task
     * @param Subscription $subscription
     * @param HttpAdapter $httpAdapter
     * @return FeedEntry[]
     * @throws FeedImportException In case an error occurs while importing Feeds
     */
    public function importNewFeeds(Subscription $subscription, HttpAdapter $httpAdapter = null);

    /**
     * Saves the list of feeds
     * @param FeedEntry[] $feeds
     * @return $this
     */
    public function saveFeeds(array $feeds);

    /**
     * Saves defined FeedEntry
     * @param FeedEntry $feed
     * @param bool $flush
     * @return $this
     */
    public function saveFeed(FeedEntry $feed, $flush = true);

    /**
     * Returns a list of unread feeds
     * @param Subscription|FeedFolder $container The Subscription or FeedFolder containing feeds
     * @param int $limit
     * @param int $offset
     * @return FeedEntry[]
     */
    public function getUnreadFeeds($container = null, $limit = 20, $offset = 0);

    /**
     * Returns a list of starred Feeds
     * @param Subscription|FeedFolder $container The Subscription or FeedFolder containing feeds
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    public function getStarredFeeds($container = null, $limit = 20, $offset = 0);
}
