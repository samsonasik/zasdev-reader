<?php
namespace RSSTest\Exception;

use PHPUnit_Framework_TestCase as TestCase;
use RSS\Exception\FeedImportException;

/**
 * Class FeedImportExceptionTest
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class FeedImportExceptionTest extends TestCase
{
    private $url = 'http://feed-source.com/atom.xml';

    public function testException()
    {
        $exception = new FeedImportException($this->url);
        $this->assertEquals(
            sprintf('An error occurred while importing feeds from %s', $this->url),
            $exception->getMessage()
        );
        $this->assertEquals(0, $exception->getCode());
        $this->assertNull($exception->getPrevious());
    }

    public function testPreviousException()
    {
        $previous = new \Exception('', -10);
        $exception = new FeedImportException($this->url, $previous);
        $this->assertEquals(
            sprintf('An error occurred while importing feeds from %s', $this->url),
            $exception->getMessage()
        );
        $this->assertEquals(-10, $exception->getCode());
        $this->assertSame($previous, $exception->getPrevious());
    }
}
