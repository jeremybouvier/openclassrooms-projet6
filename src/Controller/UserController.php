<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Handler\UserHandler;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

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
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * UserController constructor.
     * @param UserRepository $userRepository
     * @param ObjectManager $objectManager
     * @param FlashBagInterface $flashBag
     */
    public function __construct(
        UserRepository $userRepository,
        ObjectManager $objectManager,
        FlashBagInterface $flashBag
    ) {
        $this->userRepository = $userRepository;
        $this->objectManager = $objectManager;
        $this->flashBag = $flashBag;
    }

    /**
     * Ajout d'un nouveau membre
     * @Route("/enregistrement-nouveau-membre", name="user.new", methods="GET|POST")
     * @param Request $request
     * @param UserHandler $userHandler
     * @return Response
     * @throws \Exception
     */
    public function new(Request $request, UserHandler $userHandler, \Swift_Mailer $swift_Mailer) : Response
    {
        if ($userHandler->handle($request, new User())) {
            $this->sendMail($userHandler->getData(), $swift_Mailer, 'User/emailValidation.html.twig');
            return $this->redirectToRoute('trick.index');
        }

        return $this->render('User/new.html.twig', [
            'activeMenu' => 'membre',
            'user' => $userHandler->getData(),
            'form' => $userHandler->createView(),
        ]);
    }

    /**
     * Validation nouveau membre
     * @Route("/validation-membre/{token}", name="user.validation", methods="GET|POST")
     * @param string $token
     * @param Request $request
     * @param UserRepository $userRepository
     * @param UserHandler $userHandler
     * @return Response
     * @throws \Exception
     */
    public function validNewUser(
        string $token,
        Request $request,
        UserRepository $userRepository,
        UserHandler $userHandler
    ) : Response {

        $user = $userRepository->findOneBy(['token'=>$token]);
        if ($user) {
            $user->setValid(true);
            $user->setToken('');
            $this->objectManager->flush();
        }

        return $this->redirectToRoute('trick.index');
    }

    /**
     * modification du mot de passe
     * @Route("/reinitialisation-mot-de-passe/{token}", name="user.password", methods="GET|POST")
     * @param string $token
     * @param Request $request
     * @param UserRepository $userRepository
     * @param UserHandler $userHandler
     * @return Response
     * @throws \Exception
     */
    public function changePassword(
        string $token,
        Request $request,
        UserRepository $userRepository,
        UserHandler $userHandler
    ) : Response {

        $user = $userRepository->findOneBy(['token'=>$token]);
        if ($user) {
            if ($userHandler->handle($request, $user)) {
                return $this->redirectToRoute('trick.index');
            }

            return $this->render('User/initPassword.html.twig', [
                'activeMenu' => 'connexion',
                'user' => $userHandler->getData(),
                'form' => $userHandler->createView(),
            ]);
        } else {
            return $this->redirectToRoute('trick.index');
        }
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
    public function forgotPassword(Request $request, UserRepository $userRepository, \Swift_Mailer $swift_Mailer)
    : Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $user = $userRepository->findOneBy(['loginName'=> $form->getData()->getLoginName()]);
        if ($form->isSubmitted() && $form->isValid() && $user) {
            $this->sendMail(
                $user,
                $swift_Mailer,
                'User/emailForgot.html.twig'
            );
            return $this->redirectToRoute('trick.index');
        }

        return $this->render('User/forgot.html.twig', [
            'activeMenu' => 'connexion',
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Permet l'envoie d'un email
     * @param $user
     * @param $swift_Mailer
     */
    private function sendMail($user, $swift_Mailer, $view)
    {
        $message = (new \Swift_Message('JimmySweatSnowboard: Réinitialisation de votre mot de passe'))
            ->setFrom('email@JimmySweatSnowboard.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView(
                    $view,
                    [
                        'token' => $this->setToken($user),
                        'user' => $user
                    ]
                ),
                'text/html'
            )
        ;
        $swift_Mailer->send($message);
        $this->flashBag->add(
            'success',
            'Un email vous a été envoyé afin de finaliser la procédure'
        );
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
