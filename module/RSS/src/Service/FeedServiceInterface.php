<?php
namespace RSS\Service;

use RSS\Entity\Feed;
use RSS\Entity\FeedFolder;
use RSS\Entity\Subscription;
use RSS\Exception\FeedImportException;

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
     * @return Feed[]
     * @throws FeedImportException In case an error occurs while importing Feeds
     */
    public function importNewFeeds(Subscription $subscription);

    /**
     * Saves the list of feeds
     * @param Feed[] $feeds
     * @return $this
     */
    public function saveFeeds(array $feeds);

    /**
     * Saves defined Feed
     * @param Feed $feed
     * @return $this
     */
    public function saveFeed(Feed $feed);

    /**
     * Returns a list of unread feeds
     * @param Subscription|FeedFolder $container The Subscription or FeedFolder containing feeds
     * @param int $limit
     * @param int $offset
     * @return Feed[]
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
