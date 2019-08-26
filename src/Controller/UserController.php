<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Handler\UserHandler;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * UserController constructor.
     * @param UserRepository $userRepository
     * @param ObjectManager $objectManager
     */
    public function __construct(UserRepository $userRepository, ObjectManager $objectManager)
    {
        $this->userRepository = $userRepository;
        $this->objectManager = $objectManager;
    }

    /**
     * Ajout d'un nouveau membre
     * @Route("/enregistrement-nouveau-membre", name="user.new", methods="GET|POST")
     * @param Request $request
     * @param UserHandler $userHandler
     * @return Response
     * @throws \Exception
     */
    public function new(Request $request, UserHandler $userHandler) : Response
    {
        if ($userHandler->handle($request, new User())) {
            return $this->redirectToRoute('trick.index');
        }

        return $this->render('User/new.html.twig', [
            'activeMenu' => 'connexion',
            'user' => $userHandler->getData(),
            'form' => $userHandler->createView(),
        ]);
    }

    /**
     * Mot de passe perdu
     * @Route("/oubli-mot-de-passe", name="user.forgot", methods="GET|POST")
     * @param Request $request
     * @param UserRepository $userRepository
     * @param \Swift_Mailer $swift_Mailer
     * @return Response
     * @throws \Exception
     */
    public function forgotPassword(Request $request, UserRepository $userRepository, \Swift_Mailer $swift_Mailer) : Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $userRepository->findOneBy(['loginName'=> $form->getData()->getLoginName()]);
            $this->sendMail(
                $user,
                $this->setToken($user),
                $swift_Mailer
            );
            return $this->redirectToRoute('trick.index');
        }

        $user = new User;
        return $this->render('User/forgot.html.twig', [
            'activeMenu' => 'connexion',
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Permet l'envoie d'un email
     * @param $user
     * @param $token
     * @param $swift_Mailer
     */
    private function sendMail($user, $token, $swift_Mailer)
    {
        $message = (new \Swift_Message('JimmySweatSnowboard: Réinitialisation de votre mot de passe'))
            ->setFrom('email@JimmySweatSnowboard.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView(
                    'User/emailForgot.html.twig',
                    [
                        'token' => $token,
                        'user' => $user
                    ]
                ),
                'text/html'
            )
        ;
        $swift_Mailer->send($message);
    }

    /**
     * @param $user
     * @return string
     */
    private function setToken($user)
    {
        $token = sha1(uniqid());
        $user->setToken($token);
        $this->objectManager->flush();

        return $token;
    }
}
