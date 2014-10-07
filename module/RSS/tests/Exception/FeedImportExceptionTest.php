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

namespace ZasDev\RSSTest\Exception;

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
