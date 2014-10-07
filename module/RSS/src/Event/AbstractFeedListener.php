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

namespace RSS\Event;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;

/**
 * Provides an empty implementation for methods in {@see FeedListenerInterface},
 * so that children can implement only needed methods
 * @author ZasDev
 * @link https://github.com/zasDev
 */
abstract class AbstractFeedListener extends AbstractListenerAggregate implements FeedListenerInterface
{
    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     * @param int $priority
     *
     * @return void
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $events->attach(FeedEvent::EVENT_FEEDS_IMPORTED, array($this, 'onFeedsImported'), $priority);
        $events->attach(FeedEvent::EVENT_FEEDS_IMPORT_ERROR, array($this, 'onFeedsImportError'), $priority);
        $events->attach(FeedEvent::EVENT_FEED_SAVED, array($this, 'onFeedSaved'), $priority);
    }

    /**
     * Called when some Feeds are imported
     * @param FeedEvent $e
     * @return bool
     */
    public function onFeedsImported(FeedEvent $e)
    {
        return false;
    }

    /**
     * Called when an error occurs while importing feeds
     * @param FeedEVent $e
     * @return bool
     */
    public function onFeedsImportError(FeedEVent $e)
    {
        return false;
    }

    /**
     * Called when a group of feeds is saved
     * @param FeedEvent $e
     * @return bool
     */
    public function onFeedSaved(FeedEvent $e)
    {
        return false;
    }
}
