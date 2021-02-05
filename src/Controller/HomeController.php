<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Form\SearchForm;
use App\Repository\InjusticeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    /**
     * @Route("/", name="home")
     */
    public function index(InjusticeRepository $injusticeRepository, Request $request): Response
    {
        $data = new SearchData();
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        $injustices = $injusticeRepository->findSearch($data);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'injustices' => $injustices,
            'form' => $form->createView()
        ]);
    }
}
