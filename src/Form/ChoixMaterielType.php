<?php

namespace App\Form;

use App\Entity\Materiel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

class ChoixMaterielType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('materiel', EntityType::class, [
            'required'=>false,
            'class' => Materiel::class,
            'placeholder' => 'Sélectionnez un matériel',
            'label' => 'Matériel à stocker',
            'mapped'=>true,
            'constraints' => [new NotNull([
                'message' => 'Aucun matériel séléctionné! ',
            ])],
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
