<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 28/05/19
 * Time: 15:16
 */

namespace App\Controller;




use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Trick;
use App\Repository\MediaRepository;
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
        $medias = $mediaRepository->findBy(['trick'=> $tricks, 'header' => 1]);

        return $this->render('trick/index.html.twig', ['activeMenu' => 'tricks', 'tricks' => $tricks, 'medias' => $medias]);
    }

    /**
     * Affichage le detaille d'une figure
     * @Route("Figures/{id}", name="trick.show")
     * @ParamConverter("trick", class="App:Trick")
     * @param Trick $trick
     * @return Response
     */
    public function show(Trick $trick) : Response
    {
        $media = $trick->getMedias();
        $group = $trick->getGroup();
        return $this->render('trick/show.html.twig', [
            'activeMenu' => 'tricks',
            'trick' => $trick,
            'medias' => $media,
            'group'=> $group]);
    }


}