<?php
namespace Application\Entity;

use ZasDev\Common\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * ConfigParam entity
 * @author ZasDev
 * @link https://github.com/zasDev
 *
 * @ORM\Entity()
 * @ORM\Table(name="config_params")
 */
class ConfigParam extends AbstractEntity
{
    const TYPE_INTEGER  = 'integer';
    const TYPE_STRING   = 'string';
    const TYPE_BOOLEAN  = 'boolean';

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column()
     */
    private $name;
    /**
     * @var string
     *
     * @ORM\Column()
     */
    private $type;

    /**
     * @param int $id
     * @return $this;
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     * @return $this;
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $type
     * @return $this;
     */
    public function setType($type)
    {
        $this->type = $this->filterType($type);
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Checks if provided type os valid for this entity's type
     * @param $type
     * @return bool
     */
    public function isTypeValid($type)
    {
        return
            $type === self::TYPE_BOOLEAN ||
            $type === self::TYPE_INTEGER ||
            $type === self::TYPE_STRING;
    }

    /**
     * Returns defined type if it is a valid type and the default type otherwise
     * @param $type
     * @return string
     */
    protected function filterType($type)
    {
        return $this->isTypeValid($type) ? $type : self::TYPE_STRING;
    }
}
