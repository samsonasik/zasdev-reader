<?php
namespace RSS\Event;

use Zend\EventManager\ListenerAggregateInterface;

/**
 * Interface FeedListenerInterface
 * @author ZasDev
 * @link https://github.com/zasDev
 */
interface FeedListenerInterface extends ListenerAggregateInterface
{
    /**
     * Called when some Feeds are imported
     * @param FeedEvent $e
     */
    public function onFeedsImported(FeedEvent $e);

    /**
     * Called when an error occurs while importing feeds
     * @param FeedEVent $e
     */
    public function onFeedsImportError(FeedEVent $e);

    /**
     * Called when a group of feeds is saved
     * @param FeedEvent $e
     */
    public function onFeedSaved(FeedEvent $e);
}
