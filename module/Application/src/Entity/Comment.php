<?php
namespace Application\Entity;

use ZasDev\Common\Entity\AbstractEntity;
use Doctrine\ORM;

/**
 * Comment entity
 * @author ZasDev
 * @link https://github.com/zasDev
 *
 * @ORM\Entity()
 * @ORM\Table(name="comments")
 */
class Comment extends AbstractEntity
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
    private $body;
    /**
     * @var string
     *
     * @ORM\Column()
     */
    private $url;
    /**
     * @var Feed
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Feed")
     */
    private $feed;
    /**
     * @var Comment
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Comment")
     */
    private $parent;

    /**
     * @param string $body
     * @return $this;
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

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
     * @param \Application\Entity\Comment $parent
     * @return $this;
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return \Application\Entity\Comment
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Tells if this comment has a parent comment
     * @return bool
     */
    public function hasParent()
    {
        return !is_null($this->parent);
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
}
