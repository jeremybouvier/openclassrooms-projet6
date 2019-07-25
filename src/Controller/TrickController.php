<?php

namespace App\Controller;

use App\Entity\Chat;
use App\Entity\Trick;
use App\Form\ChatType;
use App\Form\TrickType;
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
     * @param Request $request
     * @return Response
     */
    public function show(Trick $trick, $page, ChatRepository $chatRepository, Request $request) : Response
    {

        $chat = new Chat();
        $form = $this->createForm(ChatType::class, $chat)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $chat->setUser($this->getUser());
            $trick->addChat($chat);
            $this->objectManager->flush();
            return $this->redirectToRoute('trick.show',['id' => $trick->getId(), 'page'=> 1, '_fragment'=>'chatZone']);
        }

        return $this->render('trick/show.html.twig', [
            'activeMenu' => 'tricks',
            'trick' => $trick,
            'chats'=>$chatRepository->findBy(['trick' => $trick], ['date' => 'DESC'], 10, ($page-1)*10),
            'pages' => ceil($chatRepository->count(['trick' => $trick])/10),
            'form' => $form->createView()
        ]);
    }

    /**
     * Modification d'une figure
     * @Route("/Membre/Edition-Figure/{id}", name="trick.update", methods="GET|POST")
     * @param Trick $trick
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function update(Trick $trick, Request $request) : Response
    {
        $form = $this->createForm(TrickType::class, $trick)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $trick->setUpdateDate(new \DateTime());
            $this->objectManager->flush();
            $this->addFlash('success', 'La figure a bien été modifié');
            return $this->redirectToRoute('trick.show',['id' => $trick->getId(),'page'=> 1]);
        }

        return $this->render('trick/edit.html.twig', [
            'active_menu' => 'trick',
            'trick' => $trick,
            'form' => $form->createView(),
            'title' =>['name'=>'Modification de la figure']
        ]);
    }

    /**
     * Ajout d'une nouvelle figure
     * @Route("/Membre/Ajout-Figure/", name="trick.new", methods="GET|POST")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function new( Request $request) : Response
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $trick->setCreationDate(new \DateTime());
            $trick->setUpdateDate(new \DateTime());
            $this->objectManager->persist($trick);
            $this->objectManager->flush();
            $this->addFlash('success', 'La figure a bien été ajouté');
            return $this->redirectToRoute('trick.index');
        }

        return $this->render('trick/edit.html.twig', [
            'active_menu' => 'trick',
            'trick' => $trick,
            'form' => $form->createView(),
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