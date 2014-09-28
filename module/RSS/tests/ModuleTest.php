<?php
namespace RSSTest;

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
