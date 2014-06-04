<?php
namespace ZasDevTest\Common\Entity;

use ZasDev\Common\Entity\AbstractEntity;

/**
 * Class AbstractEntityTest
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class AbstractEntityTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var EntityMock
     */
    private $entity;
    private $data = array(
        'foo'   => 'The Foo Value',
        'bar'   => 'The Bar value'
    );

    public function setUp()
    {
        $this->entity = new EntityMock();
    }

    public function testExchangeArray()
    {
        $this->assertCount(0, $this->entity->props);
        $this->entity->exchangeArray($this->data);

        $this->assertCount(2, $this->entity->props);
        $this->assertEquals($this->data['foo'], $this->entity->props['foo']);
        $this->assertEquals($this->data['bar'], $this->entity->props['bar']);
    }

    public function testSerialization()
    {
        $this->entity->setFoo("FooValue");
        $this->entity->setBar("BarValue");

        $serialized = $this->entity->jsonSerialize();
        $array      = $this->entity->toArray();

        $this->assertEquals($serialized, $array);
        $this->assertArrayHasKey('props', $array);
        $this->assertArrayHasKey('foo', $array['props']);
        $this->assertArrayHasKey('bar', $array['props']);
    }

} 