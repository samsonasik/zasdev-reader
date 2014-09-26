<?php
namespace RSSTest;

use PHPUnit_Framework_TestCase as TestCase;
use RSS\Module;

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
    }
}
