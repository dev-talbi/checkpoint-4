<?php

namespace App\Form;

use App\Entity\Injustice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;




class InjusticeType extends AbstractType
{
    private $session;

    public function __construct(Security $security)
    {
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
            ])
            ->add('picture')
            ->add('theme');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Injustice::class,
        ]);
    }
}
