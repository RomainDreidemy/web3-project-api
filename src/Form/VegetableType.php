<?php

namespace App\Form;

use App\Entity\Vegetable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VegetableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('water')
            ->add('fiber')
            ->add('glucose')
            ->add('protein')
            ->add('lipid')
            ->add('introText')
            ->add('cultureText')
            ->add('entretienText')
            ->add('recolteText')
            ->add('culture_start')
            ->add('culture_end')
            ->add('recolte_start')
            ->add('recolte_end')
            ->add('cycle')
            ->add('exposition')
            ->add('yield')
            ->add('family')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vegetable::class,
        ]);
    }
}
