<?php

namespace App\Controller\Main;

use Symfony\Component\Routing\Annotation\Route;

class HomeController extends BaseController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $forRender = parent::renderDefault();
        return $this->render( 'main/index.html.twig', $forRender );
    }
    /**
     * @Route("/about", name="about")
     */
    public function about()
    {
        $forRender = parent::renderDefault();
        return $this->render( 'main/about.html.twig', $forRender );
    }
   
}