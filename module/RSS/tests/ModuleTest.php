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

namespace ZasDev\RSSTest;

use PHPUnit_Framework_TestCase as TestCase;
use RSS\Module;
use Zend\Console\Adapter\Posix;

/**
 * Class ModuleTest
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class ModuleTest extends TestCase
{
    /**
     * @var Module
     */
    private $module;

    public function setUp()
    {
        $this->module = new Module();
    }

    public function testGetConfig()
    {
        $this->assertTrue(is_array($this->module->getConfig()));
        $this->assertArrayHasKey('controllers', $this->module->getConfig());
        $this->assertArrayHasKey('console', $this->module->getConfig());
    }

    public function testGetConsoleUsage()
    {
        $consoleUsage = $this->module->getConsoleUsage(new Posix());
        $this->assertTrue(is_array($consoleUsage));
        $this->assertArrayHasKey('zdr feeds --refresh [-v|--verbose]', $consoleUsage);
    }
}
