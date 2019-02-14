<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @Template("index/index.html.twig")
     */
    public function index()
    {
        return [];
    }

    /**
     * @Route("/painel", name="painel")
     * @Template("index/painel.html.twig")
     */
    public function painel()
    {
        //return new Response("<h1>Painel</h1>");
        return [];
    }
}
