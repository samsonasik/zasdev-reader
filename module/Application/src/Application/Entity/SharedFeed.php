<?php
namespace Application\Entity;

use ZasDev\Common\Entity\AbstractEntity;
use Doctrine\ORM;

/**
 * SharedFeed entity
 * @author ZasDev
 * @link https://github.com/zasDev
 *
 * @ORM\Entity()
 * @ORM\Table(name="shared_feeds")
 */
class SharedFeed extends AbstractEntity
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
    private $publicUrl;
    /**
     * @var Feed
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Feed")
     */
    private $feed;
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\User")
     */
    private $user;

    /**
     * @param \Application\Entity\Feed $feed
     * @return $this;
     */
    public function setFeed($feed)
    {
        $this->feed = $feed;
        return $this;
    }

    /**
     * @return \Application\Entity\Feed
     */
    public function getFeed()
    {
        return $this->feed;
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
     * @param string $publicUrl
     * @return $this;
     */
    public function setPublicUrl($publicUrl)
    {
        $this->publicUrl = $publicUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getPublicUrl()
    {
        return $this->publicUrl;
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

} 