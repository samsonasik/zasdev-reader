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

use Application\Entity\User;
use ZasDev\Common\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;
use ZasDev\Common\Util\UUID;

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
     * @ORM\Column(length=40, unique=true)
     */
    private $uuid;
    /**
     * @var FeedEntry
     *
     * @ORM\ManyToOne(targetEntity="RSS\Entity\FeedEntry")
     */
    private $feedEntry;
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    public function __construct()
    {
        $this->uuid = UUID::generateV4();
    }

    /**
     * @param FeedEntry $feedEntry
     * @return $this;
     */
    public function setFeedEntry($feedEntry)
    {
        $this->feedEntry = $feedEntry;
        return $this;
    }

    /**
     * @return FeedEntry
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

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
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
}
