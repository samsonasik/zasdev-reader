<?php
namespace ZasDev\Common\Entity;

/**
 * Class AbstractEntity
 * @author ZasDev
 * @link https://github.com/zasDev
 */
abstract class AbstractEntity
{

    /**
     * Populates this entity from provided array. A setter must be deffined for each property
     * @param array $properties
     */
    public function exchangeArray(array $properties = array())
    {
        foreach ($properties as $property => $value) {
            $setter = 'set' . ucfirst($property);
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }
    }

} 