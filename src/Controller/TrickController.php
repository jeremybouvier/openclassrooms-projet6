<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 28/05/19
 * Time: 15:16
 */

namespace App\Controller;


use App\Entity\Trick;
use App\Repository\TrickRepository;
use App\Repository\MediaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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
     * @return Response
     */
    public function index() : Response
    {
        $tricks = $this->trickRepository->findAll();

        return $this->render('trick/index.html.twig', ['activeMenu' => 'tricks', 'tricks' => $tricks]);
    }

    /**
     * Affichage le detail d'une figure
     * @Route("Figures/{id}", name="trick.show")
     * @param Trick $trick
     * @return Response
     */
    public function show(Trick $trick) : Response
    {
        return $this->render('trick/show.html.twig', ['activeMenu' => 'tricks', 'trick' => $trick]);
    }

}