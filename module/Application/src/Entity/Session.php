<?php
namespace Application\Entity;

use DateTime;
use ZasDev\Common\Entity\AbstractEntity;
use Doctrine\ORM;

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
     * @param DateTime $expirationDate
     * @return $this
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * @param int $id
     * @return $this
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
     * @param string $ipAddress
     * @return $this
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;
        return $this;
    }

    /**
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * @param string $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param bool $valid
     * @return $this
     */
    public function setValid($valid)
    {
        $this->valid = $valid;
        return $this;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->valid;
    }
}
