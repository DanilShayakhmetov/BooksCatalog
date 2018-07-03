<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 02.07.18
 * Time: 20:21
 */

namespace AppBundle\Controller;
use AppBundle\Entity\AuthorTab;

use AppBundle\Entity\BookTab;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Bundle\FrameworkBundle\Routing;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
class AuthorsController extends controller
{

    /**
     * @Route("/authors")
     */

    public function getAction()
    {
        $authors = $this->getDoctrine()

            ->getRepository(AuthorTab::class)
            ->findall();


        return $this->render('catalog/catalog-authors.html.twig', array(
            'authors'=>$authors,
        ));
    }

    /**
     * @Route("/setAuthor/{id}")
     */
    public function postAction($id, Request $request)
    {


        $form = $this->createFormBuilder()
            ->add('FirstName', TextType::class)
            ->add('LastName', TextType::class)
            ->add('MiddleName', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book =  $this->getDoctrine()
                ->getRepository(BookTab::class)
                ->findOneBy(['id'=>$id]);
            $Author = new AuthorTab();
            $data = $form->getData();
            $firstName = $data['FirstName'];
            $lastName = $data['LastName'];
            $middleName = $data['MiddleName'];
            if (empty($firstName) || empty($lastName)|| empty($middleName)) {
                return $this->render("base.html.twig");
            }
            $Author->setFirstName($firstName);
            $Author->setLastName($lastName);
            $Author->setMiddleName($middleName);
            $Author->setBook($book);
            $em = $this->getDoctrine()->getManager();
            $em->persist($Author);
            $em->flush();
            return $this->render('catalog/create-book.html.twig', array(
                'form' => $form->createView(),
            ));
        }
        return $this->render('catalog/create-book.html.twig', array(
            'form' => $form->createView(),
        ));
    }



    /**
     * @Route("/getby/{id}")
     *
     */
    public function getById($id){
        $books =  $this->getDoctrine()
            ->getRepository(BookTab::class)
            ->findOneBy(['id'=>$id]);

//        $books = new BookTab();
//        $books->setIsbn('Q');
//        $books->setTitle('Q');
//        $books->setPubYear('Q');

        $author = new AuthorTab();
        $author->setFirstName('Nico');
        $author->setLastName('Nico');
        $author->setMiddleName('Nico');
        $author->setBook($books);


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($author);
        $entityManager->flush();

        return $this->render('catalog/catalog-book.html.twig', array(
            'books' => $books,
        ));

    }


//    /**
//     * @Route("/authors/{id}")
//     */
//    public function getAuthors($id)
//    {
//        $book = $this->getDoctrine()
//            ->getRepository(BookTab::class)
//            ->find($id);
//        $transit = $book->getAuthors();
//        $author = dump($transit);
//        $author = $author->toArray();
//
//        return $this->render('catalog/info-book.html.twig', array(
//            'book' => $book,
//            'authors' => $author,
//        ));


}