<?php
namespace ZasDev\Common\Entity;

use Zend\Stdlib\JsonSerializable;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Stdlib\Hydrator\Reflection;

/**
 * Class AbstractEntity
 * @author ZasDev
 * @link https://github.com/zasDev
 */
abstract class AbstractEntity implements EntityInterface,
                                         JsonSerializable
{

    /**
     * @var HydratorInterface
     */
    private $hydrator;

    /**
     * Populates this entity from provided array. A setter must be deffined for each property
     * @param array $properties
     * @return $this
     */
    public function exchangeArray(array $properties = array())
    {
        foreach ($properties as $property => $value) {
            $setter = 'set' . ucfirst($property);
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }

        return $this;
    }

    /**
     * Returns this entity as an array
     * @return array
     */
    public function toArray()
    {
        return $this->jsonSerialize();
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize ()
    {
        return $this->getHydrator()->extract($this);
    }

    /**
     * Lazyloads an Hydrator object and returns it
     * @return HydratorInterface|Reflection
     */
    protected function getHydrator() {
        if (!isset($this->hydrator)) {
            $this->hydrator = new Reflection();
        }

        return $this->hydrator;
    }

}