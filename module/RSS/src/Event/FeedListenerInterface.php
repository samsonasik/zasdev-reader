<?php
namespace RSS\Event;

/**
 * Interface FeedListenerInterface
 * @author ZasDev
 * @link https://github.com/zasDev
 */
interface FeedListenerInterface
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
    public function onFeedsSaved(FeedEvent $e);
}
