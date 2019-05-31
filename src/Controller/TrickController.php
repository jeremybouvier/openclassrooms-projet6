<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 28/05/19
 * Time: 15:16
 */

namespace App\Controller;


use App\Entity\Group;
use App\Repository\GroupRepository;
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
     * @param MediaRepository $mediaRepository
     * @return Response
     */
    public function index(MediaRepository $mediaRepository) : Response
    {
        $tricks = $this->repository->findAll();
        foreach ($tricks as $trick){

            $media[] = $mediaRepository->findOneBy(['trickId'=> $trick, 'header' => 1]);
        }
        return $this->render('trick/index.html.twig', ['activeMenu' => 'tricks', 'tricks' => $tricks, 'medias' => $media]);
    }

    /**
     * Affichage le detaille d'une figure
     * @Route("Figures/{id}", name="trick.show")
     * @param $id
     * @param MediaRepository $mediaRepository
     * @param GroupRepository $groupRepository
     * @return Response
     */
    public function show($id, MediaRepository $mediaRepository, GroupRepository $groupRepository) : Response
    {
        $trick = $this->repository->find(['id' => $id]);
        $media = $mediaRepository->findBy(['trickId'=> $trick]);
    

        return $this->render('trick/show.html.twig', [
            'activeMenu' => 'tricks',
            'trick' => $trick,
            'medias' => $media]);
    }


}