<?php
namespace RSSTest\Exception;

use PHPUnit_Framework_TestCase as TestCase;
use RSS\Exception\FeedSaveException;
use ZasDev\Common\Util\UUID;

/**
 * Class FeedSaveExceptionTest
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class FeedSaveExceptionTest extends TestCase
{
    private $uuid;

    public function setUp()
    {
        $this->uuid = UUID::generateV4();
    }

    public function testException()
    {
        $exception = new FeedSaveException($this->uuid);
        $this->assertEquals(
            sprintf('The FeedEntry identified by "%s" couldn\'t be saved', $this->uuid),
            $exception->getMessage()
        );
        $this->assertEquals(0, $exception->getCode());
        $this->assertNull($exception->getPrevious());
    }

    public function testPreviousException()
    {
        $previous = new \Exception('', -10);
        $exception = new FeedSaveException($this->uuid, $previous);
        $this->assertEquals(
            sprintf('The FeedEntry identified by "%s" couldn\'t be saved', $this->uuid),
            $exception->getMessage()
        );
        $this->assertEquals(-10, $exception->getCode());
        $this->assertSame($previous, $exception->getPrevious());
    }
}
