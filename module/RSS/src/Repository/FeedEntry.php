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

namespace ZasDev\RSS\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Comparison;
use ZasDev\RSS\Entity\FeedFolder;
use ZasDev\RSS\Entity\Subscription;
use ZasDev\RSS\Entity\FeedEntry as FeedEntryEntity;

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
