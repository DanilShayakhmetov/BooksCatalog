<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use AppBundle\Entity\AuthorTab;
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
     * @ORM\Column(name="Title", type="string", length=100, unique=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="PubYear", type="string", length=25)
     */
    private $pubYear;

    /**
     * @var string
     *
     * @ORM\Column(name="Isbn", type="string", length=17, unique=true)
     */
    private $isbn;

    /**
     * @var string
     *
     * @ORM\Column(name="Cover", type="string", length=255, nullable=true)
     */
    private $cover;



//________________________________________________________________________________________
      /**
       * @ORM\OneToMany(targetEntity="BookTab", mappedBy="Book")
       * @ORM\JoinColumn(name="author_tab_id", referencedColumnName="id", nullable=false)
       *
       */

    private $Authors;


    public function __construct() {
        $this->Authors = new ArrayCollection();
    }





    /**
     * @return ArrayCollection|AuthorTab[]
     */
    public function getAuthors()
    {
        return $this->Authors;
    }




    public function addAuthor(AuthorTab $Author)
    {
        if (!$this->Authors->contains($Author)) {
            $this->Authors[] = $Author;
            $Author->setBook($this);
        }
        return $this;
    }


    public function removeAuthor(AuthorTab $Author)
    {
        if ($this->Authors->contains($Author)) {
            $this->Authors->removeElement($Author);
            // set the owning side to null (unless already changed)
            if ($Author->getBook() === $this) {
                $Author->setBook(null);
            }
        }
        return $this;
    }


//________________________________________________________________________________________


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
     * Set pubYear.
     *
     * @param string $pubYear
     *
     * @return BookTab
     */
    public function setPubYear($pubYear)
    {
        $this->pubYear = $pubYear;

        return $this;
    }

    /**
     * Get pubYear.
     *
     * @return string
     */
    public function getPubYear()
    {
        return $this->pubYear;
    }

    /**
     * Set isbn.
     *
     * @param string $isbn
     *
     * @return BookTab
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Get isbn.
     *
     * @return string
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * Set cover.
     *
     * @param string $cover
     *
     * @return BookTab
     */
    public function setCover($cover)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * Get cover.
     *
     * @return string
     */
    public function getCover()
    {
        return $this->cover;
    }
}
