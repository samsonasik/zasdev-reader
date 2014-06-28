<?php
namespace Application\Entity;

use ZasDev\Common\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * UserConfigParam entity
 * @author ZasDev
 * @link https://github.com/zasDev
 *
 * @ORM\Entity()
 * @ORM\Table(name="users_have_config_params")
 */
class UserConfigParam extends AbstractEntity
{

    /**
     * @var User
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Application\Entity\User")
     */
    private $user;
    /**
     * @var ConfigParam
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Application\Entity\ConfigParam")
     * @ORM\JoinTable(joinColumns={@ORM\JoinColumn(name="config_param_id")})
     */
    private $configParam;
    /**
     * @var string
     *
     * @ORM\Column()
     */
    private $value;

    /**
     * @param \Application\Entity\ConfigParam $configParam
     * @return $this;
     */
    public function setConfigParam($configParam)
    {
        $this->configParam = $configParam;
        return $this;
    }

    /**
     * @return \Application\Entity\ConfigParam
     */
    public function getConfigParam()
    {
        return $this->configParam;
    }

    /**
     * @param \Application\Entity\User $user
     * @return $this;
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return \Application\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $value
     * @return $this;
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Casts returned value to its type and returns it
     * @return bool|int|string
     */
    public function getCastValue()
    {
        if ($this->configParam->getType() == ConfigParam::TYPE_STRING) {
            return (string) $this->value;
        } elseif ($this->configParam->getType() == ConfigParam::TYPE_INTEGER) {
            return (int) $this->value;
        } elseif ($this->configParam->getType() == ConfigParam::TYPE_BOOLEAN) {
            return (bool) $this->value;
        } else {
            return $this->value;
        }
    }

} 