<?php

namespace App\Form;

use App\Dto\ConsumptionDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsumptionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('p1', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese el valor de P1',
                    'min' => 0,
                ],
                'label' => 'P1 (solo números enteros)',
            ])
            ->add('p2', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese el valor de P2',
                    'min' => 0,
                ],
                'label' => 'P2 (solo números enteros)',
            ])
            ->add('p3', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese el valor de P3',
                    'min' => 0,
                ],
                'label' => 'P3 (solo números enteros)',
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ConsumptionDTO::class,
        ]);
    }

}