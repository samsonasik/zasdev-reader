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
use ZasDev\RSS\Exception\FeedSaveException;
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
