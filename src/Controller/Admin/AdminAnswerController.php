<?php 

namespace App\Controller\Admin;

use App\Controller\Admin\AdminBaseController;
use App\Entity\Answer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AdminAnswerController extends AdminBaseController
{
    /**
     * @Route("/admin/answer", name = "admin_answer")
     */
    public function index()
    {
        $answer = $this->getDoctrine()->getRepository(Answer::class)
        ->findAll();

        $forRender = parent::renderDefault();
        $forRender['title'] = 'Ответы';
        $forRender['answers'] = $answer;

        return $this->render("admin/answer/index.html.twig", $forRender);
    }
}