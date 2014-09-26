<?php
namespace RSSTest\Entity;

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
