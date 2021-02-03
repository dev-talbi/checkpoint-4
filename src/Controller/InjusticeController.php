<?php

namespace App\Controller;

use App\Entity\Injustice;
use App\Form\InjusticeType;
use App\Repository\InjusticeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/injustice")
 */
class InjusticeController extends AbstractController
{
    /**
     * @Route("/", name="injustice_index", methods={"GET"})
     */
    public function index(InjusticeRepository $injusticeRepository): Response
    {
        return $this->render('injustice/index.html.twig', [
            'injustices' => $injusticeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="injustice_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $injustice = new Injustice();
        $form = $this->createForm(InjusticeType::class, $injustice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($injustice);
            $entityManager->flush();

            return $this->redirectToRoute('injustice_index');
        }

        return $this->render('injustice/new.html.twig', [
            'injustice' => $injustice,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="injustice_show", methods={"GET"})
     */
    public function show(Injustice $injustice): Response
    {
        return $this->render('injustice/show.html.twig', [
            'injustice' => $injustice,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="injustice_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Injustice $injustice): Response
    {
        $form = $this->createForm(InjusticeType::class, $injustice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('injustice_index');
        }

        return $this->render('injustice/edit.html.twig', [
            'injustice' => $injustice,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="injustice_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Injustice $injustice): Response
    {
        if ($this->isCsrfTokenValid('delete' . $injustice->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($injustice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('injustice_index');
    }
}
