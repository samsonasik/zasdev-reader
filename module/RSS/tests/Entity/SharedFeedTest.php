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

use Application\Entity\User;
use PHPUnit_Framework_TestCase as TestCase;
use RSS\Entity\FeedEntry;
use RSS\Entity\SharedFeed;
use ZasDev\Common\Util\UUID;

/**
 * Class SharedFeedTest
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class SharedFeedTest extends TestCase
{
    /**
     * @var SharedFeed
     */
    private $sharedFeed;

    public function setUp()
    {
        $this->sharedFeed = new SharedFeed();
    }

    public function testId()
    {
        $expected = 5;
        $this->assertNull($this->sharedFeed->getId());
        $this->assertSame($this->sharedFeed, $this->sharedFeed->setId($expected));
        $this->assertEquals($expected, $this->sharedFeed->getId());
    }

    public function testUuid()
    {
        $expected = UUID::generateV4();
        $this->assertNotEquals($expected, $this->sharedFeed->getUuid());
        $this->assertSame($this->sharedFeed, $this->sharedFeed->setUuid($expected));
        $this->assertEquals($expected, $this->sharedFeed->getUuid());
    }

    public function testFeedEntry()
    {
        $expected = new FeedEntry();
        $this->assertNull($this->sharedFeed->getFeedEntry());
        $this->assertSame($this->sharedFeed, $this->sharedFeed->setFeedEntry($expected));
        $this->assertSame($expected, $this->sharedFeed->getFeedEntry());
    }

    public function testUser()
    {
        $expected = new User();
        $this->assertNull($this->sharedFeed->getUser());
        $this->assertSame($this->sharedFeed, $this->sharedFeed->setUser($expected));
        $this->assertSame($expected, $this->sharedFeed->getUser());
    }
}
