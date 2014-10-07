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

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase as TestCase;
use RSS\Entity\Author;
use RSS\Entity\Comment;
use RSS\Entity\FeedEntry;
use RSS\Entity\Subscription;
use RSS\Entity\Tag;
use ZasDev\Common\Util\UUID;
use Zend\Debug\Debug;
use Zend\Feed\Reader\Entry\Atom as AtomEntry;
use Zend\Feed\Reader\Feed\Atom;
use Zend\Feed\Reader\Reader;

/**
 * Class FeedEntryTest
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class FeedEntryTest extends TestCase
{
    /**
     * @var FeedEntry
     */
    private $feedEntry;

    public function setUp()
    {
        $this->feedEntry = new FeedEntry();
    }

    public function testDefaultValues()
    {
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $this->feedEntry->getAuthors());
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $this->feedEntry->getTags());
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $this->feedEntry->getComments());
        $this->assertInstanceOf('DateTime', $this->feedEntry->getCreationDate());
        $this->assertInstanceOf('DateTime', $this->feedEntry->getModificationDate());
        $this->assertTrue($this->feedEntry->isUnread());
        $this->assertFalse($this->feedEntry->isStarred());
        $this->assertNotNull($this->feedEntry->getUuid());
    }

    public function testId()
    {
        $expected = 1;
        $this->assertNull($this->feedEntry->getId());
        $this->assertSame($this->feedEntry, $this->feedEntry->setId($expected));
        $this->assertEquals($expected, $this->feedEntry->getId());
    }

    public function testRssIndetifier()
    {
        $expected = 2;
        $this->assertNull($this->feedEntry->getRssIdentifier());
        $this->assertSame($this->feedEntry, $this->feedEntry->setRssIdentifier($expected));
        $this->assertEquals($expected, $this->feedEntry->getRssIdentifier());
    }

    public function testUuid()
    {
        $expected = UUID::generateV4();
        $this->assertNotEquals($expected, $this->feedEntry->getUuid());
        $this->assertSame($this->feedEntry, $this->feedEntry->setUuid($expected));
        $this->assertEquals($expected, $this->feedEntry->getUuid());
    }

    public function testTitle()
    {
        $expected = 'The title';
        $this->assertNull($this->feedEntry->getTitle());
        $this->assertSame($this->feedEntry, $this->feedEntry->setTitle($expected));
        $this->assertEquals($expected, $this->feedEntry->getTitle());
    }

    public function testBody()
    {
        $expected = 'The body';
        $this->assertNull($this->feedEntry->getBody());
        $this->assertSame($this->feedEntry, $this->feedEntry->setBody($expected));
        $this->assertEquals($expected, $this->feedEntry->getBody());
    }

    public function testUrl()
    {
        $expected = 'http://source.com/the-article';
        $this->assertNull($this->feedEntry->getUrl());
        $this->assertSame($this->feedEntry, $this->feedEntry->setUrl($expected));
        $this->assertEquals($expected, $this->feedEntry->getUrl());
    }

    public function testCreationDate()
    {
        $expected = new \DateTime('2012-01-01 00:00:00');
        $this->assertGreaterThan($expected, $this->feedEntry->getCreationDate());
        $this->assertSame($this->feedEntry, $this->feedEntry->setCreationDate($expected));
        $this->assertSame($expected, $this->feedEntry->getCreationDate());
    }

    public function testModificationDate()
    {
        $expected = new \DateTime('2012-01-01 00:00:00');
        $this->assertGreaterThan($expected, $this->feedEntry->getModificationDate());
        $this->assertSame($this->feedEntry, $this->feedEntry->setModificationDate($expected));
        $this->assertSame($expected, $this->feedEntry->getModificationDate());
    }

    public function testUnread()
    {
        $this->assertTrue($this->feedEntry->isUnread());
        $this->assertSame($this->feedEntry, $this->feedEntry->setUnread(false));
        $this->assertFalse($this->feedEntry->isUnread());
    }

    public function testStarred()
    {
        $this->assertFalse($this->feedEntry->isStarred());
        $this->assertSame($this->feedEntry, $this->feedEntry->setStarred(true));
        $this->assertTrue($this->feedEntry->isStarred());
    }

    public function testSubscription()
    {
        $expected = new Subscription();
        $this->assertNull($this->feedEntry->getSubscription());
        $this->assertSame($this->feedEntry, $this->feedEntry->setSubscription($expected));
        $this->assertSame($expected, $this->feedEntry->getSubscription());
    }

    public function testTags()
    {
        $this->assertCount(0, $this->feedEntry->getTags());
        $this->feedEntry->addTag(new Tag())
                        ->addTag(new Tag())
                        ->addTag(new Tag());
        $this->assertCount(3, $this->feedEntry->getTags());

        $tags = new ArrayCollection();
        $tags->add(new Tag());
        $tags->add(new Tag());
        $this->feedEntry->setTags($tags);
        $this->assertCount(2, $this->feedEntry->getTags());
        $this->assertSame($tags, $this->feedEntry->getTags());
    }

    public function testAuthors()
    {
        $this->assertCount(0, $this->feedEntry->getAuthors());
        $this->feedEntry->addAuthor(new Author())
                        ->addAuthor(new Author())
                        ->addAuthor(new Author());
        $this->assertCount(3, $this->feedEntry->getAuthors());

        $authors = new ArrayCollection();
        $authors->add(new Author());
        $authors->add(new Author());
        $this->feedEntry->setAuthors($authors);
        $this->assertCount(2, $this->feedEntry->getAuthors());
        $this->assertSame($authors, $this->feedEntry->getAuthors());
    }

    public function testComments()
    {
        $this->assertCount(0, $this->feedEntry->getComments());
        $this->feedEntry->addComment(new Comment())
                        ->addComment(new Comment())
                        ->addComment(new Comment());
        $this->assertCount(3, $this->feedEntry->getComments());

        $comments = new ArrayCollection();
        $comments->add(new Comment());
        $comments->add(new Comment());
        $this->feedEntry->setComments($comments);
        $this->assertCount(2, $this->feedEntry->getComments());
        $this->assertSame($comments, $this->feedEntry->getComments());
    }

    public function testExchangeRssEntry()
    {
        $feed = Reader::importString(include __DIR__ . '/../feed_example.php');
        /** @var AtomEntry $atomEntry */
        $atomEntry = $feed->current();
        $this->feedEntry->exchangeRssEntry($atomEntry);
        $this->assertEquals('Atom-Powered Robots Run Amok', $this->feedEntry->getTitle());
        $this->assertEquals('http://example.org/2003/12/13/atom03', $this->feedEntry->getUrl());
        $this->assertEquals('urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a', $this->feedEntry->getRssIdentifier());
        $this->assertEquals(new \DateTime('2003-12-13T18:30:02Z'), $this->feedEntry->getModificationDate());
        $this->assertEquals('Some text.', $this->feedEntry->getBody());
        $this->assertCount(1, $this->feedEntry->getAuthors());
        $this->assertEquals('John Doe', $this->feedEntry->getAuthors()->first()->getName());
        $this->assertCount(1, $this->feedEntry->getTags());
//        $this->assertEquals('Development', $this->feedEntry->getTags()->first()->getName());
    }
}
