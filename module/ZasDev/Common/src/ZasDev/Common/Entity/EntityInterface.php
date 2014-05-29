<?php
namespace ZasDev\Common\Entity;

/**
 * Interface EntityInterface
 * @author ZasDev
 * @link https://github.com/zasDev
 */
interface EntityInterface {

    /**
     * Populates this entity from provided array. A setter must be deffined for each property
     * @param array $properties
     * @return $this
     */
    public function exchangeArray(array $properties = array());

    /**
     * Returns this entity as an array
     * @return array
     */
    public function toArray();

} 