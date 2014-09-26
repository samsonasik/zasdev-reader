<?php
namespace RSSTest\Entity;

use Application\Entity\User;
use PHPUnit_Framework_TestCase as TestCase;
use RSS\Entity\FeedFolder;

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
