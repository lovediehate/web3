<?php

namespace App\Controller\Main;

use App\Entity\Question;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AskType;

class HomeController extends BaseController
{
    /**
     * @Route("/", name="home")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function index(Request $request)
    {
        
        $form = $this->createForm(AskType::class);
        $form->handleRequest($request);
        if(($form->isSubmitted()) && ($form->isValid()))
        {
            $data = $form->getData('title');
            return $this->redirectToRoute('question', $data);
        }
        $forRender = parent::renderDefault();
        $forRender['form'] = $form->createView();
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