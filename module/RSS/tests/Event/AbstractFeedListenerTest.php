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
