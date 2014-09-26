<?php
namespace Auth\Entity;

use ZasDev\Common\Entity\AbstractEntity;

/**
 * Login entity mapped with results of LoginForm
 * @see \Application\Form\LoginForm
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class Login extends AbstractEntity
{
    /**
     * @var string
     */
    private $user;
    /**
     * @var string
     */
    private $pass;
    /**
     * @var bool
     */
    private $remember;

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * @param $pass
     * @return $this
     */
    public function setPass($pass)
    {
        $this->pass = $pass;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRemember()
    {
        return $this->remember;
    }

    /**
     * @param $remember
     * @return $this
     */
    public function setRemember($remember)
    {
        $this->remember = (bool) $remember;
        return $this;
    }
}
