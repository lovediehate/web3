<?php 

namespace App\Controller\Admin;

use App\Controller\Admin\AdminBaseController;
use App\Entity\Category;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CategoryType;



class AdminCategoryController extends AdminBaseController
{
   /**
     * @Route("/admin/category", name = "admin_category")
     */
    public function index()
    {
        $category = $this->getDoctrine()->getRepository(Category::class)
        ->findAll();

        $forRender = parent::renderDefault();
        $forRender['title'] = 'Категории';
        $forRender['categories'] = $category;

        return $this->render("admin/category/index.html.twig", $forRender);
    }
    /**
     * @Route("/admin/category/create", name="admin_create_category")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function create(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);

        if(($form->isSubmitted()) && ($form->isValid()))
        {
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', 'Категория добавлена!');
            return $this->redirectToRoute('admin_category');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Форма создания категории';
        $forRender['form'] = $form->createView();
        return $this->render('admin/category/form.html.twig', $forRender);
    }
}