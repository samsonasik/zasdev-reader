<?php
namespace RSSTest\Entity;

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
