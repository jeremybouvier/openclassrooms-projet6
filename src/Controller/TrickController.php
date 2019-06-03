<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 28/05/19
 * Time: 15:16
 */

namespace App\Controller;


use App\Entity\Group;
use App\Entity\Media;
use App\Repository\CategoryRepository;
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
    public function index(MediaRepository $mediaRepository) : Response
    {
        $tricks = $this->trickRepository->findAll();

        foreach ($tricks as $trick){
        $medias[] = $trick->getMedias()->get('collection');

        }
        dump($medias);
        return $this->render('trick/index.html.twig', ['activeMenu' => 'tricks', 'tricks' => $tricks, 'medias' => $medias]);
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
        $trick = $this->trickRepository->find(['id' => $id]);
        $media = $mediaRepository->findBy(['trickId'=> $trick]);
        //$group = $groupRepository->findOneBy(['id' => $trick->getGroupId()->getId()]);
        return $this->render('trick/show.html.twig', [
            'activeMenu' => 'tricks',
            'trick' => $trick,
            'medias' => $media]);
    }


}