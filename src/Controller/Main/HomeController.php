<?php

namespace App\Controller\Main;

use App\Entity\Answer;
use App\Entity\Question;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AskType;
use App\Repository\QuestionRepository;

class HomeController extends BaseController
{
    /**
     * @Route("/", name="home")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function index(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $question = $em->getRepository(Question::class);
        $questions = $question->findAll();
        $arr = array();
        ;
        foreach ($questions as $item){
            $mass = array();
            $count = 0;
            $answers = $em->getRepository(Answer::class)
            ->findBy(
                ['question' => $item]
            );
            $count = count($answers);
            array_push($mass, $count);
            array_push($mass, $item);
            array_push($arr, $mass);
        }
        $form = $this->createForm(AskType::class);
        $form->handleRequest($request);
        if(($form->isSubmitted()) && ($form->isValid()))
        {
            $data = $form->getData('title');
            return $this->redirectToRoute('question', $data);
        }
         
        $forRender = parent::renderDefault();
        $forRender['questions'] = $arr;
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