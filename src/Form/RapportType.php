<?php

namespace App\Form;

use App\Entity\Medicament;
use App\Entity\Offrir;
use App\Entity\Rapport;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class RapportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date')
            ->add('motif', ChoiceType::class, [
                'choices' => [
                    'Choisir un motif' => [
                        'Demande du médecin' => 'Demande du médecin',
                        'Recommandation de confrère' => 'Recommandation de confrère',
                        'Conseil d\'un collègue' => 'Conseil d\'un collègue',
                        'Prise de contact' => 'Prise de contact',
                        'Visite annuelle' => 'Visite annuelle',
                        'Installation nouvelle' => 'Installation nouvelle',
                        'Installation récente' => 'Installation récente'
                    ]
                ]
            ])
            ->add('bilan')
            ->add('medecin')
            ->add('offrirs', CollectionType::class, [
                'entry_type' => OffrirType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
                'entry_options' => ['label' => false]
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rapport::class,
        ]);
    }
}
