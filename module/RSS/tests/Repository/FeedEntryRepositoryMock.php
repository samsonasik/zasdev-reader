<?php
namespace ZasDev\RSSTest\Repository;

use ZasDev\Mock\Doctrine\ObjectRepositoryMock;
use ZasDev\RSS\Entity\FeedFolder;
use ZasDev\RSS\Entity\Subscription;
use ZasDev\RSS\Entity\FeedEntry;
use ZasDev\RSS\Repository\FeedEntryInterface;

/**
 * Class FeedEntryRepositoryMock
 * @author
 * @link
 */
class FeedEntryRepositoryMock extends ObjectRepositoryMock implements FeedEntryInterface
{
    /**
     * Returns a list of unread feeds
     * @param Subscription|FeedFolder $container The Subscription or FeedFolder containing feeds
     * @param int $limit
     * @param int $offset
     * @return FeedEntry[]
     */
    public function findUnreadFeeds($container = null, $limit = 20, $offset = 0)
    {
        $feedEntries = $this->findFeeds($container, function (FeedEntry $feedEntry) {
            return $feedEntry->isUnread();
        });
        return array_slice($feedEntries, $offset, $limit);
    }

    /**
     * Returns a list of starred Feeds
     * @param Subscription|FeedFolder $container The Subscription or FeedFolder containing feeds
     * @param int $limit
     * @param int $offset
     * @return FeedEntry[]
     */
    public function findStarredFeeds($container = null, $limit = 20, $offset = 0)
    {
        $feedEntries = $this->findFeeds($container, function (FeedEntry $feedEntry) {
            return $feedEntry->isStarred();
        });
        return array_slice($feedEntries, $offset, $limit);
    }

    /**
     * @param Subscription|FeedFolder $container
     * @param callable $callable A function that will recieve each FeedEntry and return true if that feed entry is valid
     * @param $container
     * @return array
     */
    protected function findFeeds($container, $callable)
    {
        /** @var Subscription[] $subscriptions */
        $subscriptions = ($container instanceof FeedFolder)
            ? $this->getEntityManager()->getRepository(Subscription::_CLASS)->findBy(array(
                'folder' => $container
            ))
            : (array) $container;

        /** @var FeedEntry[] $feedEntries */
        $feedEntries = $this->getEntityManager()->getRepository(FeedEntry::_CLASS)->findAll();
        $validEntries = array();
        foreach ($feedEntries as $feedEntry) {
            if (
                in_array($feedEntry->getSubscription(), $subscriptions)
                && call_user_func($callable, $feedEntry) === true
            ) {
                $validEntries[] = $feedEntry;
            }
        }

        return $validEntries;
    }
}
