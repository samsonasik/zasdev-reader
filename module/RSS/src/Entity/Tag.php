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

use ZasDev\Common\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tag entity
 * @author ZasDev
 * @link https://github.com/zasDev
 *
 * @ORM\Entity()
 * @ORM\Table(name="tags")
 */
class Tag extends AbstractEntity
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
     * @var FeedEntry
     *
     * @ORM\ManyToOne(targetEntity="RSS\Entity\FeedEntry")
     */
    protected $feedEntry;

    /**
     * @param mixed $feedEntry
     * @return $this;
     */
    public function setFeedEntry($feedEntry)
    {
        $this->feedEntry = $feedEntry;
        return $this;
    }

    /**
     * @return mixed
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
}
