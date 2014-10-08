<?php
namespace ZasDev\Mock\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;

class ObjectManagerMock implements ObjectManager
{
    const DEFAULT_REPO_CLASS_NAME = 'ZasDev\Mock\Doctrine\ObjectRepositoryMock';

    /**
     * @var array
     */
    protected $cache;
    /**
     * Maps entities with repository mocks
     * @var array
     */
    protected $repositories;
    /**
     * @var bool
     */
    protected $flushed = false;
    /**
     * @var bool
     */
    protected $throwException = false;
    /**
     * @var null|\Exception
     */
    protected $exception = null;

    public function __construct(array $entityRepositoryMap = array())
    {
        $this->cache        = array();
        $this->repositories = $entityRepositoryMap;
    }

    /**
     * @param string $className The class name of the object to find.
     * @param mixed $id The identity of the object to find.
     * @return object The found object.
     */
    public function find($className, $id)
    {
        $repo = $this->getRepository($className);
        return $repo->find($id);
    }

    /**
     * @param object $object The instance to make managed and persistent.
     * @return void
     */
    public function persist($object)
    {
        $hash                           = spl_object_hash($object);
        $className                      = get_class($object);
        $this->cache[$className][$hash] = $object;

        // If the object has an ID property and it's not been set, set a random value
        if (method_exists($object, 'getId')) {
            $oldId = $object->getId();
            if (empty($oldId) && method_exists($object, 'setId')) {
                $object->setId(rand(9999, 99999999)); // Probably this number won't be used in a test
            }
        }
    }

    /**
     * @param object $object The object instance to remove.
     * @return void
     */
    public function remove($object)
    {
        $hash       = spl_object_hash($object);
        $className  = get_class($object);
        unset($this->cache[$className][$hash]);
    }

    /**
     * @param object $object
     * @return object
     */
    public function merge($object)
    {
        $cloned = clone $object;
        $this->persist($cloned);
        return $cloned;
    }

    /**
     * @param string|null $objectName if given, only objects of this type will get detached.
     * @return void
     */
    public function clear($objectName = null)
    {
        $this->cache = array();
    }

    /**
     * @param object $object The object to detach.
     * @return void
     */
    public function detach($object)
    {
        $this->remove($object);
    }

    /**
     * @param object $object The object to refresh.
     * @return void
     */
    public function refresh($object)
    {
        $hash       = spl_object_hash($object);
        $className  = get_class($object);
        if (array_key_exists($className, $this->cache) && array_key_exists($hash, $this->cache[$className])) {
            $object = $this->cache[$hash];
        }
    }

    /**
     * @param object $object
     * @return bool
     */
    public function contains($object)
    {
        $hash = spl_object_hash($object);
        foreach ($this->cache as $repository) {
            if (is_array($repository) && array_key_exists($hash, $repository)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @throws \Exception
     */
    public function flush()
    {
        if ($this->throwException) {
            throw $this->exception;
        }
        $this->flushed = true;
    }

    /**
     * @param string $className
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getRepository($className)
    {
        $repositoryName = (!array_key_exists($className, $this->repositories))
            ? self::DEFAULT_REPO_CLASS_NAME
            : $this->repositories[$className];
        return new $repositoryName(
            $this,
            $className,
            isset($this->cache[$className])? $this->cache[$className] : array()
        );
    }

    /*
     * CUSTOM METHODS
     */

    /**
     * @return array
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @return bool
     */
    public function isFlushed()
    {
        return $this->flushed;
    }

    /**
     * Tells if the next call to flush should throw an exception
     * @param bool $throwException
     * @param null $exception The exception to be thrown. A base \Exception will be thrown if not provided
     */
    public function setThrowException($throwException = true, $exception = null)
    {
        $this->throwException = (bool) $throwException;
        if ($this->throwException) {
            $this->exception = $exception instanceof \Exception ? $exception : new \Exception();
        }
    }

    /*
     * METHODS NOT YET IMPLEMENTED
     */

    /**
     * Returns the ClassMetadata descriptor for a class.
     *
     * The class name must be the fully-qualified class name without a leading backslash
     * (as it is returned by get_class($obj)).
     *
     * @param string $className
     *
     * @return \Doctrine\Common\Persistence\Mapping\ClassMetadata
     */
    public function getClassMetadata($className)
    {
        // TODO: Implement getClassMetadata() method.
    }

    /**
     * Gets the metadata factory used to gather the metadata of classes.
     *
     * @return \Doctrine\Common\Persistence\Mapping\ClassMetadataFactory
     */
    public function getMetadataFactory()
    {
        // TODO: Implement getMetadataFactory() method.
    }

    /**
     * Helper method to initialize a lazy loading proxy or persistent collection.
     *
     * This method is a no-op for other objects.
     *
     * @param object $obj
     *
     * @return void
     */
    public function initializeObject($obj)
    {
        // TODO: Implement initializeObject() method.
    }
}
