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

/**
 * Class FeedFolderTest
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class FeedFolderTest extends TestCase
{
    /**
     * @var FeedFolder
     */
    private $feedFolder;

    public function setUp()
    {
        $this->feedFolder = new FeedFolder();
    }

    public function testId()
    {
        $expected = 5;
        $this->assertNull($this->feedFolder->getId());
        $this->assertSame($this->feedFolder, $this->feedFolder->setId($expected));
        $this->assertEquals($expected, $this->feedFolder->getId());
    }

    public function testName()
    {
        $expected = 'The name';
        $this->assertNull($this->feedFolder->getName());
        $this->assertSame($this->feedFolder, $this->feedFolder->setName($expected));
        $this->assertEquals($expected, $this->feedFolder->getName());
    }

    public function testUser()
    {
        $expected = new User();
        $this->assertNull($this->feedFolder->getUser());
        $this->assertSame($this->feedFolder, $this->feedFolder->setUser($expected));
        $this->assertSame($expected, $this->feedFolder->getUser());
    }

    public function testParent()
    {
        $expected = new FeedFolder();
        $this->assertNull($this->feedFolder->getParent());
        $this->assertFalse($this->feedFolder->hasParent());
        $this->assertSame($this->feedFolder, $this->feedFolder->setParent($expected));
        $this->assertSame($expected, $this->feedFolder->getParent());
        $this->assertTrue($this->feedFolder->hasParent());
    }
}
