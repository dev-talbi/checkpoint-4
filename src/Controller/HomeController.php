<?php

namespace App\Controller;

use App\Entity\Injustice;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $injustices = $this->getDoctrine()
            ->getRepository(Injustice::class)->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'injustices' => $injustices,
        ]);
    }
}
