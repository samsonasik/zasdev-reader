<?php
namespace RSS\Event;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;

/**
 * Class FeedListener
 * @author
 * @link
 */
class FeedListener extends AbstractListenerAggregate implements FeedListenerInterface
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
        $events->attach(FeedEvent::EVENT_FEEDS_SAVED, array($this, 'onFeedsSaved'), $priority);
    }

    /**
     * Called when some Feeds are imported
     * @param FeedEvent $e
     */
    public function onFeedsImported(FeedEvent $e)
    {
        // TODO: Implement onFeedsImported() method.
    }

    /**
     * Called when a group of feeds is saved
     * @param FeedEvent $e
     */
    public function onFeedsSaved(FeedEvent $e)
    {
        // TODO: Implement onFeedsSaved() method.
    }
}
