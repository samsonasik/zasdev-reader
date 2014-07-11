<?php
namespace Application\Entity;

use ZasDev\Common\Entity\AbstractEntity;

/**
 * Subscription entity
 * @author ZasDev
 * @link https://github.com/zasDev
 *
 * @ORM\Entity()
 * @ORM\Table(name="subscriptions")
 */
class Subscription extends AbstractEntity
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
    private $name;
    /**
     * @var string
     *
     * @ORM\Column()
     */
    private $url;
    /**
     * @var string
     *
     * @ORM\Column()
     */
    private $favicon;
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\User")
     */
    private $user;
    /**
     * @var FeedFolder
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\FeedFolder")
     */
    private $folder;

    /**
     * @param string $favicon
     * @return $this;
     */
    public function setFavicon($favicon)
    {
        $this->favicon = $favicon;
        return $this;
    }

    /**
     * @return string
     */
    public function getFavicon()
    {
        return $this->favicon;
    }

    /**
     * @param FeedFolder $folder
     * @return $this;
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;
        return $this;
    }

    /**
     * @return FeedFolder
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * Tells if this subscription has to be placed in the root
     * @return bool
     */
    public function hasFolder()
    {
        return !is_null($this->folder);
    }

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
     * @param string $url
     * @return $this;
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param User $user
     * @return $this;
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
}
