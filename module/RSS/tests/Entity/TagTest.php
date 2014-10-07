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

use PHPUnit_Framework_TestCase as TestCase;
use RSS\Entity\FeedEntry;
use RSS\Entity\Tag;

/**
 * Class TagTest
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class TagTest extends TestCase
{
    /**
     * @var Tag
     */
    private $tag;

    public function setUp()
    {
        $this->tag = new Tag();
    }

    public function testId()
    {
        $expected = 1;
        $this->assertNull($this->tag->getId());
        $this->assertSame($this->tag, $this->tag->setId($expected));
        $this->assertEquals($expected, $this->tag->getId());
    }

    public function testName()
    {
        $expected = 'Pretty tag name';
        $this->assertNull($this->tag->getName());
        $this->assertSame($this->tag, $this->tag->setName($expected));
        $this->assertEquals($expected, $this->tag->getName());
    }

    public function testFeedEntry()
    {
        $expected = new FeedEntry();
        $this->assertNull($this->tag->getFeedEntry());
        $this->assertSame($this->tag, $this->tag->setFeedEntry($expected));
        $this->assertSame($expected, $this->tag->getFeedEntry());
    }
}
