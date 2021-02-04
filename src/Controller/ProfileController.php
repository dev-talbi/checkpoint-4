<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Injustice;
use App\Form\EditProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProfileController extends AbstractController
{
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    /**
     * 
     * @IsGranted("ROLE_USER")
     * @Route("/profile/{id}", name="profile")
     * 
     */
    public function index(User $user, Request $request): Response
    {
        /**
         *  profileForm for editing profile
         */
        $profileForm = $this->createForm(EditProfileType::class, $user);
        $profileForm->handleRequest($request);
        $message = "";
        if ($profileForm->isSubmitted() && $profileForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $message = "Votre profile a bien été édité !";
        }

        $user = $this->security->getUser();
        $injustices = $this->getDoctrine()
            ->getRepository(Injustice::class)
            ->findBy(['author' => $user]);
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'profileForm' => $profileForm->createView(),
            'injustices' => $injustices,
        ]);
    }
}
