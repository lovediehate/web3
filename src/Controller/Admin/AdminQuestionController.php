<?php 

namespace App\Controller\Admin;

use App\Controller\Admin\AdminBaseController;
use App\Entity\Question;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\QuestionType;


class AdminQuestionController extends AdminBaseController
{
    /**
     * @Route("/admin/question", name = "admin_question")
     */
    public function index()
    {
        $question = $this->getDoctrine()->getRepository(Question::class)
        ->findAll();

        $forRender = parent::renderDefault();
        $forRender['title'] = 'Вопросы';
        $forRender['questions'] = $question;

        return $this->render("admin/question/index.html.twig", $forRender);
    }
    /**
     * @Route("/admin/question/create", name="admin_create_question")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function create(Request $request)
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);

        if(($form->isSubmitted()) && ($form->isValid()))
        {
            $question->setCreatedAtValue();
            $question->setUpdateAtValue();

            $em->persist($question);
            $em->flush();
            $this->addFlash('succes', 'Вопрос добавлен!');
            return $this->redirectToRoute('admin_question');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Форма создания вопроса';
        $forRender['form'] = $form->createView();
        return $this->render('admin/question/form.html.twig', $forRender);
    }
}