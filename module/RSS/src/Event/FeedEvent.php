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

namespace ZasDev\RSS\Event;

use RSS\Service\FeedServiceInterface;
use Zend\EventManager\Event;

/**
 * Class FeedEvent
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class FeedEvent extends Event
{
    const EVENT_FEEDS_IMPORTED      = 'event.feeds.imported';
    const EVENT_FEEDS_IMPORT_ERROR  = 'event.feeds.imported.error';
    const EVENT_FEED_SAVED          = 'event.feed.saved';

    /**
     * @var FeedServiceInterface
     */
    protected $feedService;

    public function __construct(
        FeedServiceInterface $feedService,
        $name = self::EVENT_FEEDS_IMPORTED,
        $params = null
    ) {
        parent::__construct($name, $feedService, $params);
    }

    /**
     * Sets a FeedService as the target of this event.
     * Internally, this method calls setTarget()
     * @param \RSS\Service\FeedServiceInterface $feedService
     * @return $this;
     */
    public function setFeedService($feedService)
    {
        $this->setTarget($feedService);
        return $this;
    }

    /**
     * Returns the FeedService which is the target of this event.
     * Internally, this method calls getTarget()
     * @return \RSS\Service\FeedServiceInterface
     */
    public function getFeedService()
    {
        return $this->getTarget();
    }
}
