<?php
namespace Application\Entity;

use ZasDev\Common\Entity\AbstractEntity;
use Doctrine\ORM;

/**
 * Bookmark entity
 * @author ZasDev
 * @link https://github.com/zasDev
 *
 * @ORM\Entity()
 * @ORM\Table(name="bookmarks")
 */
class Bookmark extends AbstractEntity
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
     * @var BookmarkCategory
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\BookmarkCategory")
     */
    private $category;

    /**
     * @param \Application\Entity\BookmarkCategory $category
     * @return $this;
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return \Application\Entity\BookmarkCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

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
}
