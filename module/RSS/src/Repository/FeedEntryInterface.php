<?php
namespace RSS\Repository;

use RSS\Entity\FeedFolder;
use RSS\Entity\Subscription;

/**
 * Interface FeedEntryInterface
 * @author ZasDev
 * @link https://github.com/zasDev
 */
interface FeedEntryInterface
{
    /**
     * Returns a list of unread feeds
     * @param Subscription|FeedFolder $container The Subscription or FeedFolder containing feeds
     * @param int $limit
     * @param int $offset
     * @return FeedEntry[]
     */
    public function findUnreadFeeds($container = null, $limit = 20, $offset = 0);

    /**
     * Returns a list of starred Feeds
     * @param Subscription|FeedFolder $container The Subscription or FeedFolder containing feeds
     * @param int $limit
     * @param int $offset
     * @return FeedEntry[]
     */
    public function findStarredFeeds($container = null, $limit = 20, $offset = 0);
}
