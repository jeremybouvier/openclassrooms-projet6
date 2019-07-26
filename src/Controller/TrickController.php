<?php

namespace App\Controller;


use App\Entity\Chat;
use App\Entity\Trick;
use App\Form\ChatType;
use App\Form\TrickType;
use App\Handler\ChatHandler;
use App\Handler\TrickHandler;
use App\Repository\ChatRepository;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ObjectManager;

class TrickController extends  AbstractController
{
    /**
     * @var TrickRepository
     */
    private $trickRepository;

    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * TrickController constructor.
     * @param TrickRepository $trickRepository
     * @param ObjectManager $objectManager
     */
    public function __construct(TrickRepository $trickRepository, ObjectManager $objectManager)
    {
        $this->trickRepository = $trickRepository;
        $this->objectManager = $objectManager;
    }

    /**
     * Affichage de la liste des figures
     * @Route("Liste-des-figures", name="trick.index")
     * @return Response
     */
    public function index() : Response
    {
        return $this->render('trick/index.html.twig', [
            'activeMenu' => 'tricks',
            'tricks' => $this->trickRepository->findAll()]);
    }

    /**
     * Affichage le detail d'une figure
     * @Route("Figures/{id}/{page}", name="trick.show")
     * @param Trick $trick
     * @param $page
     * @param ChatRepository $chatRepository
     * @param ChatHandler $chatHandler
     * @param Request $request
     * @return Response
     */
    public function show(Trick $trick, $page, Request $request, ChatRepository $chatRepository, ChatHandler $chatHandler) : Response
    {
        $chatHandler
            ->createForm(ChatType::class, new Chat())
            ->handleRequest($request);

        if ($chatHandler->isFormValid()){
            $chatHandler->addChat($trick);
            return $this->redirectToRoute('trick.show',['id' => $trick->getId(), 'page'=> 1, '_fragment'=>'chatZone']);
        }

        return $this->render('trick/show.html.twig', [
            'activeMenu' => 'tricks',
            'trick' => $trick,
            'chats'=>$chatRepository->findBy(['trick' => $trick], ['date' => 'DESC'], 10, ($page-1)*10),
            'pages' => ceil($chatRepository->count(['trick' => $trick])/10),
            'form' => $chatHandler->createView()
        ]);
    }

    /**
     * Modification d'une figure
     * @Route("/Membre/Edition-Figure/{id}", name="trick.update", methods="GET|POST")
     * @param Trick $trick
     * @param Request $request
     * @param TrickHandler $trickHandler
     * @return Response
     * @throws \Exception
     */
    public function update(Trick $trick, Request $request, TrickHandler $trickHandler) : Response
    {
        $trickHandler
            ->createForm(TrickType::class, $trick)
            ->handleRequest($request);

        if ($trickHandler->isFormValid()){
            $trickHandler->updateTrick();
            return $this->redirectToRoute('trick.show',['id' => $trick->getId(),'page'=> 1]);
        }

        return $this->render('trick/edit.html.twig', [
            'active_menu' => 'trick',
            'trick' => $trickHandler->getEntity(),
            'form' => $trickHandler->createView(),
            'title' =>['name'=>'Modification de la figure']
        ]);
    }

    /**
     * Ajout d'une nouvelle figure
     * @Route("/Membre/Ajout-Figure/", name="trick.new", methods="GET|POST")
     * @param Request $request
     * @param TrickHandler $trickHandler
     * @return Response
     * @throws \Exception
     */
    public function new( Request $request, TrickHandler $trickHandler) : Response
    {
        $trickHandler
            ->createForm(TrickType::class, new Trick())
            ->handleRequest($request);

        if ($trickHandler->isFormValid()){
            $trickHandler->addTrick();
            return $this->redirectToRoute('trick.index');
        }

        return $this->render('trick/edit.html.twig', [
            'active_menu' => 'trick',
            'trick' => $trickHandler->getEntity(),
            'form' => $trickHandler->createView(),
            'title' => ['name'=>'Création de la figure']
        ]);
    }

    /**
     * Suppression d'une figure
     * @Route("/Membre/Supression-Figure/{id}", name="trick.delete", methods="DELETE")
     * @param Request $request
     * @return Response
     * @throws \Exception
     * @param Trick $trick
     */
    public function delete( Trick $trick, Request $request) : Response
    {
        if ($this->isCsrfTokenValid('delete', $request->get('_token'))){
            $this->objectManager->remove($trick);
            $this->objectManager->flush();
        }
        return $this->redirectToRoute('trick.index');
    }

}