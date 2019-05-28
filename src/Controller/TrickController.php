<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 28/05/19
 * Time: 15:16
 */

namespace App\Controller;


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
     * @return Response
     */
    public function index() : Response
    {
        $tricks = $this->repository->findAll();
        return $this->render('trick/index.html.twig', ['activeMenu' => 'tricks', 'tricks' => $tricks]);
    }


}