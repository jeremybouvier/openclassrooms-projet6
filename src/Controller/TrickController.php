<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 28/05/19
 * Time: 15:16
 */

namespace App\Controller;


use App\Repository\MediaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TrickRepository;
use Doctrine\Common\Persistence\ObjectManager;

class TrickController extends  AbstractController
{
    /**
     * @var
     */
    private $repository;

    /**
     * @var
     */
    private $manager;

    private $media;

    /**
     * TrickController constructor.
     * @param TrickRepository $repository
     * @param ObjectManager $manager
     */
    public function __construct(TrickRepository $repository, ObjectManager $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * Affichage de la liste des figures
     * @Route("Liste-des-figures", name="trick.index")
     * @return Response
     */
    public function index(MediaRepository $mediaRepository) : Response
    {
        $tricks = $this->repository->findAll();

        foreach ($tricks as $trick){

            $this->media[] = $mediaRepository->findOneBy(['trickId'=> $trick, 'header' => 1]);
        }
        dump($this->media);

        return $this->render('trick/index.html.twig', ['activeMenu' => 'tricks', 'tricks' => $tricks, 'medias' => $this->media]);
    }
}