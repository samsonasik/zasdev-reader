<?php
namespace ZasDevTest\Common\Util;

use ZasDev\Common\Util\UUID;

/**
 * Class UUIDTest
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class UUIDTest extends \PHPUnit_Framework_TestCase
{

    const SIZE = 36;

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionWithInvalidVersion()
    {
        UUID::generate("foobar");
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionWhenNoOptionsAndV3()
    {
        UUID::generate(UUID::V3, array());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionWhenNoOptionsAndV5()
    {
        UUID::generate(UUID::V5, array());
    }

    public function testGenerateV3()
    {
        $namespace  = '1546058f-5a25-4334-85ae-e68f2a44bbaf';
        $name       = 'RandomString';

        $uuid1 = UUID::generateV3($namespace, $name);
        $this->assertEquals(self::SIZE, strlen($uuid1));

        $uuid2 = UUID::generate(UUID::V3, array('namespace' => $namespace, 'name' => $name));
        $this->assertEquals(self::SIZE, strlen($uuid2));

        $this->assertEquals($uuid1, $uuid2);
    }

    public function testGenerateV4()
    {
        $uuid1 = UUID::generateV4();

        $uuid2 = UUID::generate(UUID::V4);
        $this->assertEquals(self::SIZE, strlen($uuid2));

        $this->assertNotEquals($uuid1, $uuid2);
    }

    public function testGenerateV5()
    {
        $namespace  = '1546058f-5a25-4334-85ae-e68f2a44bbaf';
        $name       = 'RandomString';

        $uuid1 = UUID::generateV5($namespace, $name);
        $this->assertEquals(self::SIZE, strlen($uuid1));

        $uuid2 = UUID::generate(UUID::V5, array('namespace' => $namespace, 'name' => $name));
        $this->assertEquals(self::SIZE, strlen($uuid2));

        $this->assertEquals($uuid1, $uuid2);
    }

} 