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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends controller
{

    /**
     * @Route("/books")
     */

    public function indexAction()
    {
        $authors = $this->getDoctrine()
            ->getRepository(AuthorTab::class)
            ->findAll();

        return $this->render('base.html.twig');
    }




}