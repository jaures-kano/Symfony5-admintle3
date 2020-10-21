<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurRolesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('roles', ChoiceType::class,
                [
                    'choices' => [
                        'GESTION DES PENSIONS' => 'ROLE_PENSION',
                        'ENREGISTREMENT' => 'ROLE_PENSION_ADMIN',
                        'CAISSE' => 'ROLE_SCOLARITE',
                        'FINANCE' => 'ROLE_SCOLARITE_ADMIN',
                        'GESTIONNAIRE' => 'ROLE_DISCIPLINE',
                        'COMMERCIAL' => 'ROLE_FOUNDER',
                        'CHEF COMMERCIAL' => 'ROLE_SUPER_ADMIN'
                    ],
                    'expanded' => true, // liste d?oulante
                    'multiple' => true, // choix multiple
                    'choice_label' => function ( $choice, $key, $value ) {
                        if ('ROLE_PENSION' === $choice) {
                            return 'La responsabilite de gerer les inscriptions et les versements';
                        } elseif ( 'ROLE_PENSION_ADMIN' === $choice ) {
                            return 'La responsabilite de gerer les inscriptions et les versements plus la modification';
                        } elseif ('ROLE_SCOLARITE' === $choice ) {
                            return 'La gestion des notes et la generation des bulletins';
                        } elseif ( 'ROLE_SCOLARITE_ADMIN' === $choice ) {
                            return 'La gestion des notes et la generation des bulletins plus la regeneration';
                        } elseif ('ROLE_DISCIPLINE' === $choice ) {
                            return 'La gestion des heures abcences';
                        } elseif ('ROLE_COMPTABLE' === $choice ) {
                            return 'La gestion des heures abcences';
                        } elseif ('ROLE_FOUNDER' === $choice ) {
                            return 'Le roles de tout geger et tout voir';
                        } elseif ('ROLE_SUPER_ADMIN' === $choice ) {
                            return 'Administrateur logiciel ';
                        }
                        return strtoupper($key);
                    }
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
