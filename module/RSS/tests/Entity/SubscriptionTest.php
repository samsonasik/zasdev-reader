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

namespace ZasDev\RSSTest\Entity;

use ZasDev\Application\Entity\User;
use PHPUnit_Framework_TestCase as TestCase;
use ZasDev\RSS\Entity\FeedFolder;
use ZasDev\RSS\Entity\Subscription;

/**
 * Class SubscriptionTest
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class SubscriptionTest extends TestCase
{
    /**
     * @var Subscription
     */
    private $subscription;

    public function setUp()
    {
        $this->subscription = new Subscription();
    }

    public function testId()
    {
        $expected = 25;
        $this->assertNull($this->subscription->getId());
        $this->assertSame($this->subscription, $this->subscription->setId($expected));
        $this->assertEquals($expected, $this->subscription->getId());
    }

    public function testName()
    {
        $expected = 'A subscription name';
        $this->assertNull($this->subscription->getName());
        $this->assertSame($this->subscription, $this->subscription->setName($expected));
        $this->assertEquals($expected, $this->subscription->getName());
    }

    public function testUrl()
    {
        $expected = 'http://foo.bar/feed/atom.xml';
        $this->assertNull($this->subscription->getUrl());
        $this->assertSame($this->subscription, $this->subscription->setUrl($expected));
        $this->assertEquals($expected, $this->subscription->getUrl());
    }

    public function testFavicon()
    {
        $expected = 'http://foo.bar/favicon.ico';
        $this->assertNull($this->subscription->getFavicon());
        $this->assertSame($this->subscription, $this->subscription->setFavicon($expected));
        $this->assertEquals($expected, $this->subscription->getFavicon());
    }

    public function testFolder()
    {
        $expected = new FeedFolder();
        $this->assertNull($this->subscription->getFolder());
        $this->assertFalse($this->subscription->hasFolder());
        $this->assertSame($this->subscription, $this->subscription->setFolder($expected));
        $this->assertSame($expected, $this->subscription->getFolder());
        $this->assertTrue($this->subscription->hasFolder());
    }

    public function testUser()
    {
        $expected = new User();
        $this->assertNull($this->subscription->getUser());
        $this->assertSame($this->subscription, $this->subscription->setUser($expected));
        $this->assertSame($expected, $this->subscription->getUser());
    }
}
