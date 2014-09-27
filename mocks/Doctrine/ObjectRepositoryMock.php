<?php
namespace ZasDev\Mock\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

class ObjectRepositoryMock implements ObjectRepository
{
    protected $cache;
    protected $className;
    protected $_em;

    public function __construct($em, $className, array $cache = array())
    {
        $this->_em          = $em;
        $this->cache        = $cache;
        $this->className    = $className;
    }

    /**
     * @param mixed $id The identifier.
     * @return object The object.
     */
    public function find($id)
    {
        foreach ($this->cache as $object) {
            if ($object->getId() === $id) {
                return $object;
            }
        }

        return null;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->cache;
    }

    /**
     * Finds objects by a set of criteria.
     *
     * Optionally sorting and limiting details can be passed. An implementation may throw
     * an UnexpectedValueException if certain values of the sorting or limiting details are
     * not supported.
     *
     * @param array $criteria
     * @param array|null $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return array The objects.
     * @throws \UnexpectedValueException
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $objects = array();

        // Find objects which accomplish the conditions
        foreach ($this->cache as $object) {
            $satisfiedConditions = 0;
            foreach ($criteria as $name => $condition) {
                $getter = $this->generateGetterName($object, $name);
                if (!isset($getter)) {
                    continue;
                }

                $returnedValue = $object->$getter();
                if ($returnedValue === $condition) {
                    // Try to find assuming the condition is a property or entity
                    $satisfiedConditions++;
                } elseif (is_object($returnedValue)) {
                    // The condition could be an entityId. Try to cast it to an entity
                    $condition = $this->getEntityManager()->find(get_class($returnedValue), $condition);
                    if (isset($condition) && $returnedValue === $condition) {
                        $satisfiedConditions++;
                    }
                }
            }
            // If all conditions are satisfied, this object accomplishes the criteria
            if (count($criteria) == $satisfiedConditions) {
                $objects[] = $object;
            }
        }

        // Order the objects
        if (isset($orderBy) && count($orderBy) > 0) {
            $orderBy = $this->castOrderByArray($orderBy);
            $repo = $this;
            usort($objects, function ($a, $b) use ($orderBy, $repo) {
                $pos = 0;
                while ($pos < count($orderBy)) {
                    $getterA = $repo->generateGetterName($a, $orderBy[$pos]['fieldName']);
                    $getterB = $repo->generateGetterName($b, $orderBy[$pos]['fieldName']);

                    if ($orderBy[$pos]['orientation'] == "ASC") {
                        if ($a->$getterA() > $b->$getterB()) {
                            return 1;
                        } elseif ($a->$getterA() < $b->$getterB()) {
                            return -1;
                        }
                    } else {
                        if ($a->$getterA() > $b->$getterB()) {
                            return -1;
                        } elseif ($a->$getterA() < $b->$getterB()) {
                            return 1;
                        }
                    }

                    $pos++;
                };

                return 0;
            });
        }

        // Apply limit and offset
        if (isset($limit)) {
            $offset = $offset ?: 0;
            $objects = array_slice($objects, $offset, $limit);
        }

        return $objects;
    }

    /**
     * Finds a single object by a set of criteria.
     *
     * @param array $criteria The criteria.
     *
     * @return object The object.
     */
    public function findOneBy(array $criteria)
    {
        $objects = $this->findBy($criteria);
        return count($objects) == 0 ? null : $objects[0];
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @return ObjectManager
     */
    public function getEntityManager()
    {
        return $this->_em;
    }

    /**
     * Generates a getter name from an object and a property name. It checks the getFoo and the isFoo forms.
     * If none of the methods exist in the object it returns null
     * @param $object
     * @param $property
     * @return null|string
     */
    public function generateGetterName($object, $property)
    {
        $getter = 'get' . ucfirst($property);
        if (!method_exists($object, $getter)) {
            $getter = 'is' . ucfirst(($property));
            if (!method_exists($object, $getter)) {
                return null;
            }
        }

        return $getter;
    }

    /**
     * Casts an orderBy array from the form of
     * [$fieldName => $orientation] to [fieldName => $fieldName, orientation => $orientation]
     * @param array $orderBy
     * @return array
     */
    protected function castOrderByArray(array $orderBy = array())
    {
        $result = array();

        foreach ($orderBy as $fieldName => $orientation) {
            if (is_int($fieldName)) {
                $fieldName      = $orientation;
                $orientation    = "ASC";
            } else {
                $orientation = strtoupper(trim($orientation));
            }

            $result[] = array(
                'fieldName'     => $fieldName,
                'orientation'   => $orientation
            );
        }

        return $result;
    }
}
