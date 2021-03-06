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
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BookController extends controller
{


     /**
     * @Route("/books")
     */

     public function getAction(Request $request)
     {
         $books = $this->getDoctrine()
         ->getRepository(BookTab::class)
         ->findAll();

         /**
          * @var $paginator \Knp\Component\Pager\Paginator
          */
         $paginator  = $this->get('knp_paginator');
         $result = $pagination = $paginator->paginate(
             $books ,
             $request->query->getInt('page', 1)/*page number*/,
             12/*limit per page*/
         );

         return $this->render('catalog/catalog-book.html.twig', array(
                 'books' => $result,
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

             $Book = new BookTab();
             $data = $form->getData();
             $title = $data['Title'];
             $year = $data['Yearofpublish'];
             $isbn = $data['ISBN'];
             if (empty($title) || empty($year) || empty($isbn)) {
                 return $this->render("base.html.twig");
             }
             $Book->setTitle($title);
             $Book->setPubYear($year);
             $Book->setIsbn($isbn);
             $response = $this->checkBook($Book);
             if ($response == "ISBN" || $response == "Title and Year of publication") {
                 $caution = "The book with the same " . $response . " already exists";
                 return $this->render('catalog/create-book.html.twig', array(
                     'form' => $form->createView(),
                     'caution' => $caution
                 ));
             } elseif($response == $Book) {
                 $em = $this->getDoctrine()->getManager();
                 $em->persist($Book);
                 $em->flush();
                 return $this->render('catalog/createdSuccessful.html.twig');

             }
         }
         return $this->render('catalog/create-book.html.twig', array(
             'form' => $form->createView(),
             'caution'=>''
         ));
     }


     public function checkBook(BookTab $Book)
     {
        $title = $Book->getTitle();
        $year = $Book->getPubYear();
        $isbn = $Book->getIsbn();
        $findBookByIsbn = $this->getDoctrine()
            ->getRepository(BookTab::class)
            ->findOneBy(['isbn'=>$isbn]);
        $findBookByTitleYear = $this->getDoctrine()
            ->getRepository(BookTab::class)
            ->findOneBy(['title'=>$title,'pubYear'=>$year]);
        if($findBookByIsbn){
            $response = "ISBN";
            return $response;
        }
        elseif($findBookByTitleYear){
            $response = "Title and Year of publication";
            return $response;
        }
        else{
            return $Book;
        }
     }


    /**
     * @Route("/putBook/{id}")
     *
     */
    public function putAction($id,Request $request)
    {
        $Book = $this->getDoctrine()
            ->getRepository(BookTab::class)
            ->find($id);
        $title = $Book->getTitle();
        $year = $Book->getPubYear();
        $isbn = $Book->getIsbn();
        $form = $this->createFormBuilder()
            ->add('Title', TextType::class, array('data'=>$title))
            ->add('YearOfPublish', TextType::class,array('data'=>$year))
            ->add('ISBN',TextType::class, array('data'=>$isbn))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $title = $data['Title'];
            $year = $data['YearOfPublish'];
            $isbn = $data['ISBN'];
            if(!empty($title)) {
                $Book->setTitle($title);
            }
            if(!empty($year)){
                $Book->setPubYear($year);
            }
            if(!empty($isbn)){
                $Book->setIsbn($isbn);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($Book);
            $em->flush();
            return $this->render('catalog/changedSuccessful.html.twig');
        }
        return $this->render('catalog/put-book.html.twig',array(
            'form'=>$form->createView(),
            'book'=>$Book,

        ));
    }

        /**
         * @Route("/deleteBook/{id}")
         *
         */
    public function  deleteAction($id)
    {
        $Book = $this->getDoctrine()
            ->getRepository(BookTab::class)
            ->findOneBy(['id'=>$id]);
        if(empty($Book)){
            return $this->render('base.html.twig');
        }else{
            $em = $this->getDoctrine()->getManager();
            $em->remove($Book);
            $em->flush();
            return $this->render('catalog/deletedSuccessful.html.twig');
        }
    }


}