<?php
namespace Application\Entity;

use ZasDev\Common\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Session entity
 * @author ZasDev
 * @link https://github.com/zasDev
 *
 * @ORM\Entity()
 * @ORM\Table(name="sessions")
 */
class Session extends AbstractEntity
{
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
    private $token;
    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $valid;
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="expiration_date")
     */
    private $expirationDate;
    /**
     * @var string
     *
     * @ORM\Column(name="ip_address")
     */
    private $ipAddress;
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\User")
     */
    private $user;

    /**
     * @param mixed $expirationDate
     * @return $this
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * @param mixed $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $ipAddress
     * @return $this
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * @param mixed $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $valid
     * @return $this
     */
    public function setValid($valid)
    {
        $this->valid = $valid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function isValid()
    {
        return $this->valid;
    }
}
