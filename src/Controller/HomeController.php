<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 21/05/19
 * Time: 21:06
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @return Response
     */
    Public function index() : Response
    {
        return $this->redirectToRoute('trick.index');
    }

}