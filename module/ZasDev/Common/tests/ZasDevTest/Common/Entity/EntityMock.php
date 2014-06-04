<?php
namespace ZasDevTest\Common\Entity;

use ZasDev\Common\Entity\AbstractEntity;

class EntityMock extends AbstractEntity
{

    public $props = array();

    public function setFoo($foo)
    {
        $this->props['foo'] = $foo;
    }

    public function setBar($bar)
    {
        $this->props['bar'] = $bar;
    }

} 