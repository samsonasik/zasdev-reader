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

namespace ZasDev\RSSTest\Service;

use PHPUnit_Framework_TestCase as TestCase;
use ZasDev\Mock\ServiceManager\ServiceManagerMock;
use ZasDev\RSS\Event\FeedEvent;
use ZasDev\RSS\Service\FeedServiceDelegatorFactory;
use Zend\Log\Logger;

/**
 * Class FeedServiceDelegatorFactoryTest
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class FeedServiceDelegatorFactoryTest extends TestCase
{
    /**
     * @var FeedServiceDelegatorFactory
     */
    protected $factory;

    public function setUp()
    {
        $this->factory = new FeedServiceDelegatorFactory();
    }

    public function testCreateDelegatorWithName()
    {
        $feedService = new FeedServiceMock();
        $this->assertCount(0, $feedService->getEventManager()->getListeners(FeedEvent::EVENT_FEED_SAVED));
        $this->assertCount(0, $feedService->getEventManager()->getListeners(FeedEvent::EVENT_FEEDS_IMPORTED));
        $this->assertCount(0, $feedService->getEventManager()->getListeners(FeedEvent::EVENT_FEEDS_IMPORT_ERROR));

        $callable = function () use ($feedService) {
            return $feedService;
        };

        $this->assertSame($feedService, $this->factory->createDelegatorWithName(
            $this->createServiceManager(),
            '',
            '',
            $callable
        ));

        $this->assertCount(1, $feedService->getEventManager()->getListeners(FeedEvent::EVENT_FEED_SAVED));
        $this->assertCount(1, $feedService->getEventManager()->getListeners(FeedEvent::EVENT_FEEDS_IMPORTED));
        $this->assertCount(1, $feedService->getEventManager()->getListeners(FeedEvent::EVENT_FEEDS_IMPORT_ERROR));
    }

    /**
     * @return ServiceManagerMock
     */
    private function createServiceManager()
    {
        $logger = new Logger();
        return new ServiceManagerMock(array(
            'RSS\Logger' => $logger
        ));
    }
}
