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

namespace ZasDev\RSSTest\Event;

use PHPUnit_Framework_TestCase as TestCase;
use ZasDev\RSS\Entity\Subscription;
use ZasDev\RSS\Event\FeedEvent;
use ZasDev\RSS\Event\LoggerFeedListener;
use ZasDev\RSS\Entity\FeedEntry;
use ZasDev\RSSTest\Service\FeedServiceMock;
use Zend\Log\Logger;
use Zend\Log\Writer;

class LoggerFeedListenerTest extends TestCase
{
    /**
     * @var LoggerFeedListener
     */
    private $listener;
    /**
     * @var Writer\Mock
     */
    private $writer;

    public function setUp()
    {
        $this->writer = new Writer\Mock();
        $logger = new Logger();
        $logger->addWriter($this->writer);
        $this->listener = new LoggerFeedListener($logger);
    }

    public function testOnFeedsImported()
    {
        $expectedEntries = 9;
        $event = $this->createEvent(FeedEvent::EVENT_FEEDS_IMPORTED, array('totalFeedEntries' => $expectedEntries));
        $this->assertTrue($this->listener->onFeedsImported($event));
        $this->assertCount(1, $this->writer->events);
        $this->assertEquals(Logger::INFO, $this->writer->events[0]['priority']);
        $this->assertEquals('INFO', $this->writer->events[0]['priorityName']);
        $this->assertEquals(sprintf('Imported %s feed entries', $expectedEntries), $this->writer->events[0]['message']);
    }

    public function testOnFeedsImportError()
    {
        $exception = new \Exception('This is the exception message', -1);
        $event = $this->createEvent(FeedEvent::EVENT_FEEDS_IMPORT_ERROR, array('exception' => $exception));
        $this->assertTrue($this->listener->onFeedsImportError($event));
        $this->assertCount(1, $this->writer->events);
        $this->assertEquals(Logger::ERR, $this->writer->events[0]['priority']);
        $this->assertEquals('ERR', $this->writer->events[0]['priorityName']);
        $this->assertEquals(
            'An error occurred while importing feed entries' . PHP_EOL .
            $exception->getMessage() . PHP_EOL . $exception->getTraceAsString(),
            $this->writer->events[0]['message']
        );
    }

    public function testOnFeedSaved()
    {
        $subscription = new Subscription();
        $subscription->setName('The subscription name');
        $feedEntry = new FeedEntry();
        $feedEntry->setTitle('The entry title')
                  ->setSubscription($subscription);

        $event = $this->createEvent(FeedEvent::EVENT_FEED_SAVED, array('feedEntry' => $feedEntry));
        $this->assertTrue($this->listener->onFeedSaved($event));
        $this->assertCount(1, $this->writer->events);
        $this->assertEquals(Logger::INFO, $this->writer->events[0]['priority']);
        $this->assertEquals('INFO', $this->writer->events[0]['priorityName']);
        $this->assertEquals(
            sprintf(
                'Saved feed entry with title "%s" from Subscription with name "%s"',
                $feedEntry->getTitle(),
                $subscription->getName()
            ),
            $this->writer->events[0]['message']
        );
    }

    /**
     * @param $name
     * @param array $params
     * @return FeedEvent
     */
    private function createEvent($name, array $params)
    {
        $event = new FeedEvent(new FeedServiceMock(), $name);
        $event->setParams($params);
        return $event;
    }
}
