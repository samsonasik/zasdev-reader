<?php
namespace RSSTest\Event;

use RSS\Event\FeedEvent;
use RSSTest\Service\FeedServiceMock;
use Zend\EventManager\EventManager;
use PHPUnit_Framework_TestCase as TestCase;
use RSS\Event\FeedListenerInterface;
use Zend\EventManager\EventManagerInterface;

class AbstractFeedListenerTest extends TestCase
{
    /**
     * @var FeedListenerInterface
     */
    private $feedListener;
    /**
     * @var EventManagerInterface
     */
    private $eventManager;

    public function setUp()
    {
        $this->feedListener = $this->getMock('RSS\Event\AbstractFeedListener', null);

        $this->eventManager = new EventManager();
        $this->eventManager->attach($this->feedListener);
    }

    /**
     * @covers \RSS\Event\AbstractFeedListener::onFeedsImported
     */
    public function testOnFeedsImported()
    {
        $resp = $this->eventManager->trigger(new FeedEvent(new FeedServiceMock()));
        $this->assertTrue($resp->contains(false));
    }

    public function testOnFeedsImportError()
    {
        $resp = $this->eventManager->trigger(new FeedEvent(new FeedServiceMock(), FeedEvent::EVENT_FEEDS_IMPORT_ERROR));
        $this->assertTrue($resp->contains(false));
    }

    public function testOnFeedSaved()
    {
        $resp = $this->eventManager->trigger(new FeedEvent(new FeedServiceMock(), FeedEvent::EVENT_FEED_SAVED));
        $this->assertTrue($resp->contains(false));
    }
}
