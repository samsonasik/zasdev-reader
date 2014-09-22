<?php
namespace RSS\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Comparison;
use RSS\Entity\FeedFolder;
use RSS\Entity\Subscription;
use RSS\Entity\FeedEntry as FeedEntryEntity;

/**
 * Class FeedEntry
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class FeedEntry extends EntityRepository implements FeedEntryInterface
{
    /**
     * Returns a list of unread feeds
     * @param Subscription|FeedFolder $container The Subscription or FeedFolder containing feeds
     * @param int $limit
     * @param int $offset
     * @return FeedEntryEntity[]
     */
    public function findUnreadFeeds($container = null, $limit = 20, $offset = 0)
    {
        return $this->findFeeds(
            new Comparison('fe.unread', Comparison::EQ, true),
            $container,
            $limit,
            $offset
        );
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
        return $this->findFeeds(
            new Comparison('fe.starred', Comparison::EQ, true),
            $container,
            $limit,
            $offset
        );
    }

    /**
     * @param $condition
     * @param null $container
     * @param int $limit
     * @param int $offset
     * @return array
     */
    protected function findFeeds($condition, $container = null, $limit = 20, $offset = 0)
    {
        // If provided container is a FeedFolder, get all of its subscriptions
        /** @var Subscription[] $subscriptions */
        $subscriptions = ($container instanceof FeedFolder)
            ? $this->getEntityManager()->getRepository(Subscription::_CLASS)->findBy(array(
                    'folder' => $container
                ))
            : (array) $container;

        $qb = $this->createQueryBuilder('fe');
        $qb->where($qb->expr()->in('fe.subscription', ':subscriptions'))
           ->setParameter('subscriptions', $subscriptions)
           ->andWhere($condition)
           ->setMaxResults($limit)
           ->setFirstResult($offset);

        return $qb->getQuery()->getResult();
    }
}
