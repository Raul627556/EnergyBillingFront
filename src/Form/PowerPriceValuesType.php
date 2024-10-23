<?php

namespace App\Form;

use App\Dto\PowerPriceValuesDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PowerPriceValuesType extends AbstractType
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
                'scale' => 2,
                'grouping' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese el valor de P1',
                ],
            ])
            ->add('p2', NumberType::class, [
                'scale' => 2,
                'grouping' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese el valor de P2',
                ],
            ])
            ->add('p3', NumberType::class, [
                'scale' => 2,
                'grouping' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese el valor de P3',
                ],
            ]);
    }


    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PowerPriceValuesDTO::class,
        ]);
    }

}