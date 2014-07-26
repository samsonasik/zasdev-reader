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
    const EVENT_FEEDS_IMPORTED  = 'event.feeds.imported';
    const EVENT_FEEDS_SAVED     = 'event.feeds.saved';

    /**
     * @var FeedServiceInterface
     */
    protected $feedService;

    public function __construct(
        FeedServiceInterface $feedService,
        $name = self::EVENT_FEEDS_IMPORTED,
        $target = null,
        $params = null
    ) {
        parent::__construct($name, $target, $params);
        $this->feedService = $feedService;
    }

    /**
     * @param \RSS\Service\FeedServiceInterface $feedService
     * @return $this;
     */
    public function setFeedService($feedService)
    {
        $this->feedService = $feedService;
        return $this;
    }

    /**
     * @return \RSS\Service\FeedServiceInterface
     */
    public function getFeedService()
    {
        return $this->feedService;
    }
}
