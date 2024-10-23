<?php

namespace App\Form;

use App\Dto\ContractedPowerDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContractedPowerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('p1', NumberType::class, [
                'scale' => 1,
                'grouping' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese el valor de P1',
                    'step' => '0.1',
                    'min' => 0,
                ],
                'label' => 'P1 (máximo 1 decimal)',
            ])
            ->add('p2', NumberType::class, [
                'scale' => 1,
                'grouping' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese el valor de P2',
                    'step' => '0.1',
                    'min' => 0,
                ],
                'label' => 'P2 (máximo 1 decimal)',
            ])
            ->add('p3', NumberType::class, [
                'scale' => 1, // Limitar a 1 decimal
                'grouping' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese el valor de P3',
                    'step' => '0.1',
                    'min' => 0,
                ],
                'label' => 'P3 (máximo 1 decimal)',
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContractedPowerDTO::class,
        ]);
    }

}