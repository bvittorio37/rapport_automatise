<?php

namespace App\Form;

use App\Entity\Materiel;
use App\Entity\Site;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChoixApprovisionnementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('materiel', EntityType::class, [
            'required'=>true,
            'class' => Materiel::class,
            'placeholder' => 'Sélectionnez le materiel',
            'label'=> 'Matériel',
            'mapped'=>false,
            'attr' => [
                'class' => 'form-control',
            ],
        ])
        ->add('site', EntityType::class, [
            'required'=>true,
            'class' => Site::class,
            'placeholder' => 'Sélectionnez le Site',
            'label'=> 'Site à approvisionner',
            'mapped'=>false,
            'attr' => [
                'class' => 'form-control',
            ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
