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

namespace ZasDev\RSS\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use ZasDev\Common\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;
use ZasDev\Common\Util\UUID;
use Zend\Feed\Reader\Entry\AbstractEntry;
use Zend\Feed\Reader\Entry\Atom;

/**
 * FeedEntry entity
 * @author ZasDev
 * @link https://github.com/zasDev
 *
 * @ORM\Entity(repositoryClass="RSS\Repository\FeedEntry")
 * @ORM\Table(
 *     name="feed_entries",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="rss_identifier", columns={"rss_identifier", "subscription_id"})}
 * )
 */
class FeedEntry extends AbstractEntity implements RssEntryExchangeableInterface
{
    const _CLASS = __CLASS__;

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
     * @ORM\Column(name="rss_identifier")
     */
    private $rssIdentifier;
    /**
     * @var string
     *
     * @ORM\Column(length=40, unique=true)
     */
    private $uuid;
    /**
     * @var string
     *
     * @ORM\Column(length=1024, nullable=true)
     */
    private $title;
    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $body;
    /**
     * @var string
     *
     * @ORM\Column(length=1024)
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
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="RSS\Entity\Comment",
     *     mappedBy="feedEntry",
     *     cascade={"persist"}
     * )
     */
    private $comments;

    public function __construct()
    {
        // Initialize tags and authors as an empty list
        $this->tags     = new ArrayCollection();
        $this->authors  = new ArrayCollection();
        $this->comments = new ArrayCollection();

        // Initialize both dates as the current date
        $this->creationDate     = new DateTime();
        $this->modificationDate = new DateTime();

        $this->unread   = true;
        $this->starred  = false;

        $this->uuid = UUID::generateV4();
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
        $this->setRssIdentifier($entry->getId());

        // Set authors
        $this->getAuthors()->clear();
        foreach ($entry->getAuthors() as $author) {
            $authorEntity = new Author();
            $authorEntity->exchangeArray($author);
            $authorEntity->setFeedEntry($this);
            $this->addAuthor($authorEntity);
        }

        // Set tags
        $this->getTags()->clear();
        foreach ($entry->getCategories() as $category) {
            $tag = new Tag();
            $tag->setName($category['label']);
            $tag->setFeedEntry($this);
            $this->addTag($tag);
        }

        $this->setCreationDate($entry->getDateCreated());
        $this->setModificationDate($entry->getDateModified());

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
     * @param boolean $unread
     * @return $this;
     */
    public function setUnread($unread = true)
    {
        $this->unread = $unread;
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
    public function setStarred($starred = true)
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
     * @return Subscription
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

    /**
     * @param string $uuid
     * @return $this;
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
     * @param string $rssIdentifier
     * @return $this;
     */
    public function setRssIdentifier($rssIdentifier)
    {
        $this->rssIdentifier = $rssIdentifier;
        return $this;
    }

    /**
     * @return string
     */
    public function getRssIdentifier()
    {
        return $this->rssIdentifier;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $comments
     * @return $this;
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param Comment $comment
     * @return $this
     */
    public function addComment(Comment $comment)
    {
        $this->comments->add($comment);
        return $this;
    }
}
