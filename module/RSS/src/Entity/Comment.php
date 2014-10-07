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

use ZasDev\Application\Entity\User;
use ZasDev\Common\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(nullable=true)
     */
    private $body;
    /**
     * @var string
     *
     * @ORM\Column(length=1024, nullable=true)
     */
    private $url;
    /**
     * @var FeedEntry
     *
     * @ORM\ManyToOne(targetEntity="RSS\Entity\FeedEntry")
     */
    private $feedEntry;
    /**
     * @var Comment
     *
     * @ORM\ManyToOne(targetEntity="RSS\Entity\Comment")
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
     * @param \RSS\Entity\FeedEntry $feed
     * @return $this;
     */
    public function setFeedEntry($feed)
    {
        $this->feedEntry = $feed;
        return $this;
    }

    /**
     * @return \RSS\Entity\FeedEntry
     */
    public function getFeedEntry()
    {
        return $this->feedEntry;
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
     * @param Comment $parent
     * @return $this;
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return Comment
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
