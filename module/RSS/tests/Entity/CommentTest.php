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
use ZasDev\RSS\Entity\Comment;
use ZasDev\RSS\Entity\FeedEntry;

class CommentTest extends TestCase
{
    /**
     * @var Comment
     */
    private $comment;

    public function setUp()
    {
        $this->comment = new Comment();
    }

    public function testId()
    {
        $expected = 4;
        $this->assertNull($this->comment->getId());
        $this->assertSame($this->comment, $this->comment->setId($expected));
        $this->assertEquals($expected, $this->comment->getId());
    }

    public function testBody()
    {
        $expected = $this->generateRandomString(500);
        $this->assertNull($this->comment->getBody());
        $this->assertSame($this->comment, $this->comment->setBody($expected));
        $this->assertEquals($expected, $this->comment->getBody());
    }

    public function testUrl()
    {
        $expected = 'http://domain.com/foo-bar';
        $this->assertNull($this->comment->getUrl());
        $this->assertSame($this->comment, $this->comment->setUrl($expected));
        $this->assertEquals($expected, $this->comment->getUrl());
    }

    public function testFeedEntry()
    {
        $expected = new FeedEntry();
        $this->assertNull($this->comment->getFeedEntry());
        $this->assertSame($this->comment, $this->comment->setFeedEntry($expected));
        $this->assertSame($expected, $this->comment->getFeedEntry());
    }

    public function testParent()
    {
        $expected = new Comment();
        $this->assertNull($this->comment->getParent());
        $this->assertFalse($this->comment->hasParent());
        $this->assertSame($this->comment, $this->comment->setParent($expected));
        $this->assertSame($expected, $this->comment->getParent());
        $this->assertTrue($this->comment->hasParent());
    }

    /**
     * Generates a random string of provided length
     * @param $length
     * @return string
     */
    private function generateRandomString($length)
    {
        $characters = ' 0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}
