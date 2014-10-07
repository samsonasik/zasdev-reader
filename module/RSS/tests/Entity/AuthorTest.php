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

namespace RSSTest\Entity;

use PHPUnit_Framework_TestCase as TestCase;
use RSS\Entity\Author;
use RSS\Entity\FeedEntry;

class AuthorTest extends TestCase
{
    /**
     * @var Author
     */
    private $author;

    public function setUp()
    {
        $this->author = new Author();
    }

    public function testId()
    {
        $expected = 5;
        $this->assertNull($this->author->getId());
        $this->assertSame($this->author, $this->author->setId($expected));
        $this->assertEquals($expected, $this->author->getId());
    }

    public function testName()
    {
        $expected = 'John Doe';
        $this->assertNull($this->author->getName());
        $this->assertSame($this->author, $this->author->setName($expected));
        $this->assertEquals($expected, $this->author->getName());
    }

    public function testEmail()
    {
        $expected = 'example@domain.com';
        $this->assertNull($this->author->getEmail());
        $this->assertSame($this->author, $this->author->setEmail($expected));
        $this->assertEquals($expected, $this->author->getEmail());
    }

    public function testUri()
    {
        $expected = 'https://domain.com/foo-bar';
        $this->assertNull($this->author->getUri());
        $this->assertSame($this->author, $this->author->setUri($expected));
        $this->assertEquals($expected, $this->author->getUri());
    }

    public function testFeedEntry()
    {
        $expected = new FeedEntry();
        $this->assertNull($this->author->getFeedEntry());
        $this->assertSame($this->author, $this->author->setFeedEntry($expected));
        $this->assertSame($expected, $this->author->getFeedEntry());
    }
}
