<?php

namespace App\Form;

use App\Entity\Medicament;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedicamentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id')
            ->add('nomCommercial')
            ->add('composition')
            ->add('effets')
            ->add('contreIndications')
            ->add('familleId', ChoiceType::class, [
                'choices' => [
                    'Choisir une famille' => [
                        'Antalgiques en association' => 'AA',
                        'Antalgiques antipyréques en association' => 'AAA',
                        'Antidépresseur d action centrale' => 'AAC',
                        'Antivertigineux antihistaminique H1' => 'AAH',
                        'Antibiotique antituberculeux' => 'ABA',
                        'Antibiotique antiacnénique local' => 'ABC',
                        'Antibiotique de la famille des béta-lactamines -pénicilline A-' => 'ABP',
                        'Antibiotique de la famille des cyclines' => 'AFC',
                        'Antibiotique de la famille des macrolides' => 'AFM',
                        'Antihistaminique H1 local' => 'AH',

                        'Antidépresseur imipraminique -tricyclique-' => 'AIM',
                        'Antidépresseur inhibiteur sélectif de la recapture de la sétonine' => 'AIN',
                        'Antibiotique local -ORL-' => 'ALO',
                        'Antidépresseur IMAO non sélectif' => 'ANS',
                        'Antibiotique ophtalmique' => 'AO',
                        'Antipsychotique normothymique' => 'AP',
                        'Antibiotique urinaire minute' => 'AUM',
                        'Corticoide, antibiotique et antifongique à usage local' => 'CRT',
                        'Hypnotique antihistaminique' => 'HYP',
                        'Psychostimulant antiasthésique' => 'PSA'
                    ]
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Medicament::class,
        ]);
    }
}
