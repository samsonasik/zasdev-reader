<?php
namespace RSS\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use ZasDev\Common\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;
use Zend\Feed\Reader\Entry\AbstractEntry;
use Zend\Feed\Reader\Entry\Atom;

/**
 * FeedEntry entity
 * @author ZasDev
 * @link https://github.com/zasDev
 *
 * @ORM\Entity()
 * @ORM\Table(name="feed_entries")
 */
class FeedEntry extends AbstractEntity implements RssEntryExchangeableInterface
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
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $unread;
    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $starred;
    /**
     * @var Subscription
     *
     * @ORM\ManyToOne(targetEntity="RSS\Entity\Subscription")
     */
    private $subscription;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="RSS\Entity\Tag",
     *     mappedBy="feedEntry",
     *     cascade={"persist"}
     * )
     */
    private $tags;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="RSS\Entity\Author",
     *     mappedBy="feedEntry",
     *     cascade={"persist"}
     * )
     */
    private $authors;

    public function __construct()
    {
        // Initialize tags and authors as an empty list
        $this->tags     = new ArrayCollection();
        $this->authors  = new ArrayCollection();

        // Initialize both dates as the current date
        $this->creationDate     = new DateTime();
        $this->modificationDate = new DateTime();

        $this->unread   = true;
        $this->starred  = false;
    }

    /**
     * Populates this FeedEntry with the entry content
     * @param AbstractEntry $entry
     * @return $this
     */
    public function exchangeRssEntry(AbstractEntry $entry)
    {
        /* @var Atom $entry */
        $this->setBody($entry->getContent());
        $this->setTitle($entry->getTitle());
        $this->setUrl($entry->getPermalink());
        foreach ($entry->getAuthors() as $author) {
            $authorEntity = new Author();
            $authorEntity->exchangeArray($author);
            $authorEntity->setFeedEntry($this);
            $this->addAuthor($authorEntity);
        }
        foreach ($entry->getCategories() as $category) {
            $tag = new Tag();
            $tag->setName($category['label']);
            $tag->setFeedEntry($this);
            $this->addTag($tag);
        }

        // TODO Save dateCreated, dateModified and entry id

        return $this;
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
    public function setUnread($read)
    {
        $this->unread = $read;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isUnread()
    {
        return $this->unread;
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
     * @param \RSS\Entity\Subscription $subscription
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
     * @param Tag $tag
     * @return $this
     */
    public function addTag(Tag $tag)
    {
        $this->tags->add($tag);
        return $this;
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

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $authors
     * @return $this;
     */
    public function setAuthors($authors)
    {
        $this->authors = $authors;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * @param Author $author
     * @return $this
     */
    public function addAuthor(Author $author)
    {
        $this->authors->add($author);
        return $this;
    }
}
