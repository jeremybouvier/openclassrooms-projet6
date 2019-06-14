<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 28/05/19
 * Time: 15:16
 */

namespace App\Controller;


use App\Entity\Chat;
use App\Entity\Trick;
use App\Form\ChatType;
use App\Repository\ChatRepository;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ObjectManager;


class TrickController extends  AbstractController
{
    /**
     * @var
     */
    private $trickRepository;

    /**
     * @var
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
     * @param MediaRepository $mediaRepository
     * @return Response
     */
    public function index() : Response
    {
        $tricks = $this->trickRepository->findAll();

        return $this->render('trick/index.html.twig', ['activeMenu' => 'tricks', 'tricks' => $tricks]);
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
        $form = $this->createForm(ChatType::class, $chat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $trick->addChat($chat);
            $this->objectManager->flush();
            return $this->redirectToRoute('trick.show',['id' => $trick->getId(), 'page'=> 1]);
        }

       $chats = $chatRepository->findBy(['trick' => $trick], ['date' => 'DESC'], 10, ($page-1)*10);
       $pages = ceil($chatRepository->count(['trick' => $trick])/10);

        return $this->render('trick/show.html.twig', [
            'activeMenu' => 'tricks',
            'trick' => $trick,
            'chats'=>$chats,
            'pages' => $pages,
            'form' => $form->createView()
        ]);

    }

}