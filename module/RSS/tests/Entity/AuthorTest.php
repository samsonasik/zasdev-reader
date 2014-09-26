<?php
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
