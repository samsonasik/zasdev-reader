<?php
namespace RSS\Service;

use Doctrine\Common\Persistence\ObjectManager;
use RSS\Entity\Feed;
use RSS\Entity\FeedFolder;
use RSS\Entity\Subscription;
use RSS\Exception\FeedImportException;
use ZasDev\Common\Service\AbstractService;
use Zend\Authentication\AuthenticationService;

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
     * @return Feed[]
     * @throws FeedImportException In case an error occurs while importing Feeds
     */
    public function importNewFeeds(Subscription $subscription)
    {
        // TODO: Implement importNewFeeds() method.
    }

    /**
     * Saves the list of feeds
     * @param Feed[] $feeds
     * @return $this
     */
    public function saveFeeds(array $feeds)
    {
        foreach ($feeds as $feed) {
            $this->saveFeed($feed);
        }
    }

    /**
     * Saves defined Feed
     * @param Feed $feed
     * @return $this
     */
    public function saveFeed(Feed $feed)
    {
        // TODO: Implement saveFeed() method.
    }

    /**
     * Returns a list of unread feeds
     * @param Subscription|FeedFolder $container The Subscription or FeedFolder containing feeds
     * @param int $limit
     * @param int $offset
     * @return Feed[]
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
}
