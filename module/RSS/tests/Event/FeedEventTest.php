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
