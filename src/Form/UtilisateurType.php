<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom' , TextType::class , [
                'attr' => [
                    'placeholder' => 'Nom de l\'utilisateur'
                ]
            ])
            ->add('genre' , ChoiceType::class, [
                'choices' => [
                    '-- GENRE --' => '',
                    'HOMME' => 'HOMME',
                    'FEMME' => 'FEMME',
                ]
            ])
            ->add('prenom' , TextType::class , [
                'attr' => [
                    'placeholder' => 'Prenom de l\'utilisateur '
                ]
            ])
            ->add('fonction' , TextType::class , [
                'attr' => [
                    'placeholder' => 'Fonction de l\'utilisateur '
                ]
            ])
            /* ->add('password', PasswordType::class,
                [
                    'mapped' => false,
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'Veiller entrer un mot de passe'
                            ]),
                        new Length(
                            [
                                'min' => 6,
                                'minMessage' => 'Your password should be at least {{ limit }} characters',
                                'max' => 4096
                            ])
                    ],
                    'attr' => [
                        'placeholder' => 'Mot de passe '
                    ]
                ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
