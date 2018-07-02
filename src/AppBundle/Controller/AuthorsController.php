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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class AuthorsController extends controller
{

    /**
     * @Route("/authors")
     */

    public function indexAction()
    {
        $authors = $this->getDoctrine()
            ->getRepository(AuthorTab::class)
            ->findAll();

        return $this->render('base.html.twig');
    }







}