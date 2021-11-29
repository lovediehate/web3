<?php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Controller\Main\BaseController;

class SecurityController extends BaseController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('home');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
     /**
     * @Route("/signup", name="signup")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function signup(Request $request, UserPasswordHasherInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);

        if(($form->isSubmitted()) && ($form->isValid()))
        {
            $user->setEmail($form->get('email')->getData());
            if (null != $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $user->getEmail()])) {
                return $this->render('security/signup.html.twig', [
                    'form' => $form->createView(),
                    'error' => 'Пользователь с введенным email уже существует'
                ]);
            }
            $password = $passwordEncoder->hashPassword($user, $form->get('plainPassword')->getData());
            $user->setPassword($password);
            $user->setRoles(['ROLE_USER']);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('home');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Регистрация';
        $forRender['form'] = $form->createView();
        return $this->render('security/signup.html.twig', $forRender);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
