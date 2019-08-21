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

        return $this->render('User/edit.html.twig', [
            'activeMenu' => 'connexion',
            'user' => $userHandler->getData(),
            'form' => $userHandler->createView(),
        ]);
    }
}
