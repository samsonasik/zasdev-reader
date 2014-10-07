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

namespace ZasDev\RSSTest\Service;

use ZasDev\RSS\Entity\FeedEntry;
use ZasDev\RSS\Entity\FeedFolder;
use ZasDev\RSS\Entity\Subscription;
use ZasDev\RSS\Exception\FeedImportException;
use ZasDev\RSS\Service\FeedServiceInterface;
use Zend\Http\Client\Adapter\AdapterInterface as HttpAdapter;

class FeedServiceMock implements FeedServiceInterface
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
        // TODO: Implement importNewFeeds() method.
    }

    /**
     * Saves the list of feeds
     * @param FeedEntry[] $feeds
     * @return $this
     */
    public function saveFeeds(array $feeds)
    {
        // TODO: Implement saveFeeds() method.
    }

    /**
     * Saves defined FeedEntry
     * @param FeedEntry $feed
     * @param bool $flush
     * @return $this
     */
    public function saveFeed(FeedEntry $feed, $flush = true)
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
}
