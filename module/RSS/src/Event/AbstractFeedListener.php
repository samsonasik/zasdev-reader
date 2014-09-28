<?php
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
