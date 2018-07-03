<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 02.07.18
 * Time: 23:32
 */

namespace AppBundle\Controller;
use AppBundle\Entity\AuthorTab;
use AppBundle\Entity\BookTab;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Bundle\FrameworkBundle\Routing;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BookController extends controller
{

//    /**
//     * @Route("/books")
//     */
//
//    public function indexAction()
//    {
//        $authors = $this->getDoctrine()
//            ->getRepository(AuthorTab::class)
//            ->findAll();
//
//        return $this->render('base.html.twig');
//    }
//



     /**
     * @Route("/books")
     */

     public function getCatalogAction()
     {
     $books = $this->getDoctrine()
     ->getRepository(BookTab::class)
     ->findAll();


         return $this->render('catalog/catalog-book.html.twig', array(
             'books' => $books,
         ));
     }



    /**
     * @Route("/book/{id}")
     */
    public function getBookByAuthor($id)
    {
        $author = $this->getDoctrine()
            ->getRepository(AuthorTab::class)
            ->findOneBy(['id'=>$id]);
        $transit = $author->getBook();
        $title = $transit->getTitle();
        $isbn = $transit->getIsbn();
        $getPubYear = $transit->getPubYear();

        return $this->render('catalog/info-book.html.twig', array(
            'author' => $author,
            'title' => $title,
            'isbn' => $isbn,
            'pubYear' => $getPubYear,
        ));

    }




    /**
     *  @Route("/setBook/")
     */
     public function postAction(Request $request, EntityManagerInterface $em)
     {
     $form = $this->createFormBuilder()

     ->add('Title', TextType::class)
     ->add('Yearofpublish', TextType::class)
     ->add('ISBN', TextType::class)
     ->getForm();

     $form->handleRequest($request);

     if ($form->isSubmitted() && $form->isValid()) {

     $book = new BookTab();
     $data = $form->getData();
     $title = $data['Title'];
     $year = $data['Yearofpublish'];
     $isbn = $data['ISBN'];
     if (empty($title) || empty($year) || empty($isbn)) {
     return $this->render("base.html.twig");
     }
     $book->setTitle($title);
     $book->setPubYear($year);
     $book->setIsbn($isbn);
     $em = $this->getDoctrine()->getManager();
     $em->persist($book);
     $em->flush();
//     return $this->render('base.html.twig');
     }
     return $this->render('create-book.html.twig', array(
     'form' => $form->createView(),
     ));
     }







}