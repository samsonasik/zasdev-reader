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

use ZasDev\RSS\Entity\FeedFolder;
use ZasDev\RSS\Entity\Subscription;

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
