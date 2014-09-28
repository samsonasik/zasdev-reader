<?php
namespace RSS\Event;

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
