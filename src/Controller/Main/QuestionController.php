<?php 

namespace App\Controller\Main;

use App\Controller\Main\BaseController;
use App\Entity\Question;
use App\Entity\Answer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\QuestionType;
use App\Form\AnswerType;

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
            $question->setUser($this->getUser());    
            $em->persist($question);
            $em->flush();
            $this->addFlash('success', 'Вопрос добавлен!');
            return $this->redirectToRoute('home');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Форма создания вопроса';
        $forRender['form'] = $form->createView();
        return $this->render('main/question/form.html.twig', $forRender);
    }
    /**
     * @Route("/post/{id}", name="post")
     * @param int $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function post(Request $request, int $id)
    {   
        $em = $this->getDoctrine()->getManager();
        $question = $em->getRepository(Question::class)
        ->find($id);
        $answers = $this->getDoctrine()->getRepository(Answer::class)
        ->findAll();
        $answer = new Answer();
        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);
        $content = $form->get('content')->getData();
        
        if(($form->isSubmitted()) && ($form->isValid()))
        {
            $answer->setUser($this->getUser());
            $answer->setCreateAtValue();
            $answer->setUpdateAtValue();
            $answer->setQuestion($question);
            
            $answer->setContent($content);   
            $em->persist($answer);
            $em->flush();
            $this->addFlash('success', 'Вопрос добавлен!');
            return $this->redirectToRoute('post', ['id' => $id]);
        }
        $forRender = parent::renderDefault();
        $forRender['form'] = $form->createView();
        $forRender['answers'] = $answers;
        $forRender['question'] = $question;
        
        return $this->render('main/question/post.html.twig', $forRender);   
    }
}