<?php
namespace RSS\Entity;

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
