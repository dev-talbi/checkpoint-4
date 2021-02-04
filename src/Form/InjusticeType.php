<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Injustice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;




class InjusticeType extends AbstractType
{
    private $session;

    public function __construct(Security $security)
    {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->security->getUser();

        $builder
            ->add('title')
            ->add('description', TextareaType::class)
            ->add('date')
            ->add('author', EntityType::class, array(
                'class'   => 'App:User',
                'choice_label'    => 'pseudo',
                'multiple' => false,
                'data' => $user

            ), [
                'attr' => ['class' => 'hider'],
            ]);
        var_dump($user->getPseudo());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Injustice::class,
        ]);
    }
}
