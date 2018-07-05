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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;




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
        $response = array();
        $inside = array();
        foreach ($authors as $author){
            $first = $author->getFirstName();
            $first = str_split($first);
            $middle = $author->getMiddleName();
            $middle = str_split($middle);
            $last = $author->getLastName();
            $name = $last.'. '.$first[0].'. '.$middle[0];
            $id = $author->getId();
            $inside = array('id'=>$id,'name'=>$name);
            $response[] = $inside;
        }


        return $this->render('catalog/catalog-authors.html.twig', array(
            'authors' => $response,
        ));
    }


    /**
     * @Route("/setAuthor/{id}")
     */
    public function postAction($id, Request $request)
    {

        $allAuthors = $this->getDoctrine()
            ->getRepository(AuthorTab::class)
            ->findAll();
        $form = $this->createFormBuilder()
            ->add('FirstName', TextType::class)
            ->add('LastName', TextType::class)
            ->add('MiddleName', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book = $this->getDoctrine()
                ->getRepository(BookTab::class)
                ->findOneBy(['id' => $id]);
            $Author = new AuthorTab();
            $data = $form->getData();
            $firstName = $data['FirstName'];
            $lastName = $data['LastName'];
            $middleName = $data['MiddleName'];
            if (empty($firstName) || empty($lastName) || empty($middleName)) {
                return $this->render("base.html.twig");
            }
            $Author->setFirstName($firstName);
            $Author->setLastName($lastName);
            $Author->setMiddleName($middleName);
            $Author->setBook($book);
            $result = $this->checkAuthor($Author);
            if ($result == null) {
                $caution = "The author with the same name already exists";
                return $this->render('catalog/create-author.html.twig', array(
                    'form' => $form->createView(),
                    'caution' => $caution
                ));
            } else {

                $em = $this->getDoctrine()->getManager();
                $em->persist($Author);
                $em->flush();
                return $this->render('catalog/createdSuccessful.html.twig');
            }
        }
        return $this->render('catalog/create-author.html.twig', array(
            'form' => $form->createView(),
            'caution' => ''
        ));
    }


    public function checkAuthor(AuthorTab $Author)
    {

        $firstName = $Author->getFirstName();
        $lastName = $Author->getLastName();
        $middleName = $Author->getMiddleName();
        $allAuthors  =  $this->getDoctrine()
            ->getRepository(AuthorTab::class)
            ->findOneBy(array('firstName'=> $firstName,'lastName'=>$lastName,'middleName'=>$middleName));
        if ($allAuthors == null){
            return $Author;
        } else {

            return null;
        }

    }


    /**
     * @Route("/delete/{id}")
     */
    public function  deleteAction($id)
    {
        $Author =  $this->getDoctrine()
            ->getRepository(AuthorTab::class)
            ->findOneBy(array('id'=>$id));
        if(empty($Author)){
            return $this->render('base.html.twig');
        }else{
            $em = $this->getDoctrine()->getManager();
            $em->remove($Author);
            $em->flush();
            return $this->render('catalog/deletedSuccessful.html.twig');
        }
    }

    /**
     * @Route("/putAuthor/{id}")
     */
    public function putAction($id, Request $request)
    {
        $Author = $this
            ->getDoctrine()
            ->getRepository(AuthorTab::class)
            ->find($id);

        $firstName = $Author->getFirstName();
        $lastName = $Author->getLastName();
        $middleName = $Author->getMiddleName();

        $form  = $this
            ->createFormBuilder()
            ->add('FirstName',TextType::class, array('data'=>$firstName))
            ->add('LastName',TextType::class, array('data'=>$lastName))
            ->add('MiddleName',TextType::class, array('data'=>$middleName))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $data = $form->getData();
            $firstName = $data['FirstName'];
            $lastName = $data['LastName'];
            $middleName = $data['MiddleName'];
            if(empty($firstName)||empty($lastName)||empty($middleName))
            {
                return $this->render('base.html.twig');
            }
            $Author->setFirstName($firstName);
            $Author->setLastName($lastName);
            $Author->setMiddleName($middleName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($Author);
            $em->flush();
            return $this->render('catalog/changedSuccessful.html.twig');

            }
        return $this->render('catalog/put-author.html.twig', array(
            'form'=>$form->createView(),
            'author'=>$Author,
        ));
    }

}
