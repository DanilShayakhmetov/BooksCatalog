<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * AuthorTab
 *
 * @ORM\Table(name="author_tab")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AuthorTabRepository")
 */
class AuthorTab
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
     * @ORM\Column(name="LastName", type="string", length=50)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="FirstName", type="string", length=25)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="MiddleName", type="string", length=25)
     */
    private $middleName;



    /**
     * @ORM\ManyToOne(targetEntity="BookTab", inversedBy="Authors", cascade={"remove"})
     * @ORM\JoinColumn(name="book_tab_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    private $Book;


    /**
     * Get id.
     *
     * @return BookTab
     */
    public function getBook()
    {
        return $this->Book;
    }

    /**
     * @param mixed $Book
     */
    public function setBook(BookTab $Book)
    {
        $this->Book = $Book;
    }


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
     * Set lastName.
     *
     * @param string $lastName
     *
     * @return AuthorTab
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set firstName.
     *
     * @param string $firstName
     *
     * @return AuthorTab
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set middleName.
     *
     * @param string $middleName
     *
     * @return AuthorTab
     */
    public function setMiddleName($middleName)
    {
         $this->middleName = $middleName;

        return $this;
    }

    /**
     * Get middleName.
     *
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }
}
