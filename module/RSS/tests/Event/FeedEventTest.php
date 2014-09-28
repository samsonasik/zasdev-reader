<?php
namespace RSSTest\Event;

use PHPUnit_Framework_TestCase as TestCase;
use RSS\Event\FeedEvent;
use RSS\Service\FeedServiceInterface;
use RSSTest\Service\FeedServiceMock;

/**
 * Class FeedEventTest
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class FeedEventTest extends TestCase
{
    public function testConstructorDefaultArguments()
    {
        $feedService = new FeedServiceMock();
        $event = new FeedEvent($feedService);
        $this->assertEquals(FeedEvent::EVENT_FEEDS_IMPORTED, $event->getName());
        $this->assertSame($feedService, $event->getFeedService());
        $this->assertSame($feedService, $event->getTarget());
        $this->assertCount(0, $event->getParams());
    }

    public function testConstructorWithCustomArguments()
    {
        $feedService = new FeedServiceMock();
        $event = new FeedEvent($feedService, FeedEvent::EVENT_FEED_SAVED, array('foo' => 'bar', 'baz' => 45));
        $this->assertEquals(FeedEvent::EVENT_FEED_SAVED, $event->getName());
        $this->assertSame($feedService, $event->getFeedService());
        $this->assertSame($feedService, $event->getTarget());
        $this->assertCount(2, $event->getParams());
        $this->assertEquals('bar', $event->getParam('foo'));
        $this->assertEquals(45, $event->getParam('baz'));
    }

    public function testOverrideFeedService()
    {
        $feedService = new FeedServiceMock();
        $event = new FeedEvent($feedService);
        $this->assertSame($feedService, $event->getFeedService());

        $anotherFeedService = new FeedServiceMock();
        $event->setFeedService($anotherFeedService);
        $this->assertSame($anotherFeedService, $event->getFeedService());
    }
}
