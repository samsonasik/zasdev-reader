<?php
/*
 * This file is part of ZasDev Reader.
 *
 * ZasDev Reader is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ZasDev Reader is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ZasDev Reader. If not, see <http://www.gnu.org/licenses/>.
 */

namespace ZasDev\Application\Entity;

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
     * @ORM\ManyToOne(targetEntity="ZasDev\Application\Entity\User")
     */
    private $user;
    /**
     * @var ConfigParam
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="ZasDev\Application\Entity\ConfigParam")
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
        $type = $this->getConfigParam()->getType();
        switch ($type) {
            case ConfigParam::TYPE_STRING:
                return (string) $this->getValue();
            case ConfigParam::TYPE_INTEGER:
                return (int) $this->getValue();
            case ConfigParam::TYPE_BOOLEAN:
                return (bool) $this->getValue();
            default:
                return $this->getValue();
        }
    }
}
