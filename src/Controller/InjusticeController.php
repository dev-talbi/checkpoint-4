<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\Comments;
use App\Entity\PostLike;
use App\Entity\Injustice;
use App\Form\CommentsType;
use App\Form\InjusticeType;
use App\Repository\PostLikeRepository;
use App\Repository\InjusticeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/injustice")
 */
class InjusticeController extends AbstractController
{
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
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
        $user = new User();
        $form = $this->createForm(InjusticeType::class, $injustice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($injustice);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('injustice/new.html.twig', [
            'injustice' => $injustice,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="injustice_show", methods={"GET","POST"})
     */
    public function show(Request $request, Injustice $injustice): Response
    {
        $user = $this->security->getUser();
        $comment = new Comments;
        $commentForm = $this->createForm(CommentsType::class, $comment);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment->setCreatedAt(new DateTime());
            $comment->setInjustice($injustice);
            $comment->setUser($user);
            $parentid = $commentForm->get("parentid")->getData();
            $em = $this->getDoctrine()->getManager();
            if ($parentid != null) {
                $parent = $em->getRepository(Comments::class)->find($parentid);
            }
            $comment->setParent($parent ?? null);
            $em->persist($comment);
            $em->flush();
            $this->addFlash('message', 'Votre commentaire a bien été envoyé');
        }
        return $this->render('injustice/show.html.twig', [
            'injustice' => $injustice,
            'commentForm' => $commentForm->createView(),
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

            return $this->redirectToRoute('home');
        }

        return $this->render('injustice/edit.html.twig', [
            'injustice' => $injustice,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/{id}", name="injustice_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Injustice $injustice): Response
    {
        if ($this->isCsrfTokenValid('delete' . $injustice->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($injustice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/{id}/like", name="post_like")
     */
    public function like(Injustice $injustice, EntityManagerInterface $manager, PostLikeRepository $likeRepo): Response
    {
        $user = $this->getUser();
        if (!$user) return $this->json([
            'code' => 403,
            'message' => 'Vous n\'ete pas conecter'
        ], 403);

        if ($injustice->isLikedByUser($user)) {
            $like = $likeRepo->findOneBy([
                'injustice' => $injustice,
                'user' => $user
            ]);
            $manager->remove($like);
            $manager->flush();
            return $this->json([
                'code' => 200,
                'message' => 'like bien supprimé',
                'likes' => $likeRepo->count(['injustice' => $injustice])
            ], 200);
        }
        $like = new PostLike();
        $like->setInjustice($injustice)->setUser($user);
        $manager->persist($like);
        $manager->flush();
        return $this->json([
            'code' => 200,
            'message' => 'cela fonctione',
            'likes' => $likeRepo->count(['injustice' => $injustice])
        ], 200);
    }
}
