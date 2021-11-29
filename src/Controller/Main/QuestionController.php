<?php 

namespace App\Controller\Main;

use App\Controller\Main\BaseController;
use App\Entity\Question;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\QuestionType;

class QuestionController extends BaseController
{
    /**
     * @Route("/question", name="question")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function create(Request $request)
    {
        $question = new Question();
        $data=$request->query;
        $title = $data->get('title');
        $form = $this->createForm(QuestionType::class, $question, ['arg' => $title]);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);

        if(($form->isSubmitted()) && ($form->isValid()))
        {
            $question->setCreatedAtValue();
            $question->setUpdateAtValue();

            $em->persist($question);
            $em->flush();
            $this->addFlash('success', 'Вопрос добавлен!');
            return $this->redirectToRoute('question');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Форма создания вопроса';
        $forRender['form'] = $form->createView();
        return $this->render('main/question/form.html.twig', $forRender);
    }
}