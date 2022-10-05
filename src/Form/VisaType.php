<?php

namespace App\Form;

use App\Entity\Visa;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'required'=>true,
                'mapped'=>true,
                'choices'  => [
                        'Pour vol Arrivé' => 'A',
                        'Pour vol Départ' => 'D',
                    ],
                'attr' => [
                        'class' => 'form-control',
                    ],
                ])
            ->add('intitule')
            ->add('remarque')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Visa::class,
        ]);
    }
}
