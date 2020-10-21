<?php

namespace App\Form\Personnels;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordResetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword' , PasswordType::class , [
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Entrez l\'ancien mot de passe'
                ]
            ])
            ->add('newPassword' , PasswordType::class , [
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Entrez le nouveau mot de passe'
                ]
            ] )
            ->add('confirmPassword' , PasswordType::class , [
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Confirmer le nouveau mot de passe'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
