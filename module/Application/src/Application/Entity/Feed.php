<?php
namespace Application\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use ZasDev\Common\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Feed entity
 * @author ZasDev
 * @link https://github.com/zasDev
 *
 * @ORM\Entity()
 * @ORM\Table(name="feeds")
 */
class Feed extends AbstractEntity
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
    private $title;
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
     * @var DateTime
     *
     * @ORM\Column(type="datetime", name="creation_date")
     */
    private $creationDate;
    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime", name="modification_date")
     */
    private $modificationDate;
    /**
     * @var string
     *
     * @ORM\Column()
     */
    private $author;
    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $read;
    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $starred;
    /**
     * @var Subscription
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Subscription")
     */
    private $subscription;
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Application\Entity\Tag")
     * @ORM\JoinTable(
     *     name="feeds_have_tags",
     *     joinColumns={@ORM\JoinColumn(name="feed_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     * )
     */
    private $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection(); // Initialize tags as an empty list
    }

    /**
     * @param string $author
     * @return $this;
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

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
     * @param \DateTime $creationDate
     * @return $this;
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
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
     * @param \DateTime $modificationDate
     * @return $this;
     */
    public function setModificationDate($modificationDate)
    {
        $this->modificationDate = $modificationDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getModificationDate()
    {
        return $this->modificationDate;
    }

    /**
     * @param boolean $read
     * @return $this;
     */
    public function setRead($read)
    {
        $this->read = $read;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isRead()
    {
        return $this->read;
    }

    /**
     * @param boolean $starred
     * @return $this;
     */
    public function setStarred($starred)
    {
        $this->starred = $starred;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isStarred()
    {
        return $this->starred;
    }

    /**
     * @param \Application\Entity\Subscription $subscription
     * @return $this;
     */
    public function setSubscription($subscription)
    {
        $this->subscription = $subscription;
        return $this;
    }

    /**
     * @return \Application\Entity\Subscription
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $tags
     * @return $this;
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param string $title
     * @return $this;
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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