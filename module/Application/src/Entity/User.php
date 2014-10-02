<?php
namespace Application\Entity;

use ZasDev\Common\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;
use ZasDev\Common\Util\UUID;

/**
 * User entity
 * @author ZasDev
 * @link https://github.com/zasDev
 *
 * @ORM\Entity()
 * @ORM\Table(name="users")
 */
class User extends AbstractEntity
{
    const HASHED    = true;
    const PLAIN     = false;

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
     * @ORM\Column(length=128, unique=true, nullable=true)
     */
    private $email;
    /**
     * @var string
     *
     * @ORM\Column(length=40, unique=true)
     */
    private $uuid;
    /**
     * @var string
     *
     * @ORM\Column(length=128, unique=true)
     */
    private $username;
    /**
     * @var string
     *
     * @ORM\Column(length=128)
     */
    private $password;
    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $enabled;
    /**
     * @var Role
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Role")
     */
    private $role;

    /**
     * Sets default values
     */
    public function __construct()
    {
        $this->enabled  = true;
        $this->uuid     = UUID::generateV4();
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param boolean $enabled
     * @return $this
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
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
     * @param string $name
     * @return $this
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
     * @param string $password
     * @param bool $hash Tells if the password should be hashed
     * @return $this
     */
    public function setPassword($password, $hash = self::HASHED)
    {
        $this->password = $hash ? password_hash($password, PASSWORD_DEFAULT) : $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param \Application\Entity\Role $role
     * @return $this
     */
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @return \Application\Entity\Role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $uuid
     * @return $this
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Checks if provided plain text password corresponds to provided user's hashed password
     * Used for Doctrine authentication credential callable
     * @param User $user
     * @param $password
     * @return bool
     */
    public static function isPasswordValid(User $user, $password)
    {
        return password_verify($password, $user->getPassword());
    }
}
