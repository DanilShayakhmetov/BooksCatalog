<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BookTab
 *
 * @ORM\Table(name="book_tab")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BookTabRepository")
 */
class BookTab
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Title", type="string", length=75, unique=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="З�PubYear", type="string", length=25)
     */
    private $З�PubYear;

    /**
     * @var string
     *
     * @ORM\Column(name="ISBN", type="string", length=17, unique=true)
     */
    private $iSBN;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Cover", type="string", length=255, nullable=true)
     */
    private $cover;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return BookTab
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set З�PubYear.
     *
     * @param string $З�PubYear
     *
     * @return BookTab
     */
    public function setЗ�PubYear($З�PubYear)
    {
        $this->З�PubYear = $З�PubYear;

        return $this;
    }

    /**
     * Get З�PubYear.
     *
     * @return string
     */
    public function getЗ�PubYear()
    {
        return $this->З�PubYear;
    }

    /**
     * Set iSBN.
     *
     * @param string $iSBN
     *
     * @return BookTab
     */
    public function setISBN($iSBN)
    {
        $this->iSBN = $iSBN;

        return $this;
    }

    /**
     * Get iSBN.
     *
     * @return string
     */
    public function getISBN()
    {
        return $this->iSBN;
    }

    /**
     * Set cover.
     *
     * @param string|null $cover
     *
     * @return BookTab
     */
    public function setCover($cover = null)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * Get cover.
     *
     * @return string|null
     */
    public function getCover()
    {
        return $this->cover;
    }
}
