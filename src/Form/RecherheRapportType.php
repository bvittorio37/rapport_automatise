<?php

namespace App\Form;

use App\Entity\Rapport;
use App\Entity\Site;
use App\Entity\TypeRapport;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecherheRapportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typeRapport', EntityType::class, array(
                'placeholder' => 'Toutes les vols',
                'class' => TypeRapport::class,
                'label' => false,
                'required' => false,
            ))
            ->add('site', EntityType::class, array(
                'placeholder' => 'Tout les sites',
                'class' => Site::class,
                'label' => false,
                'required' => false,
                'mapped'=>false,
            ))
            ->add('dateDebut', DateType::class, array(
                'required' => false,
                'mapped'=>false,
                'label' => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control input-inline datetimepicker float-right',
                    'html5' => false,
                ],
                ))
            ->add('dateFin', DateType::class, array(
                'required' => false,
                'mapped'=>false,
                'label' => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control input-inline datetimepicker float-right',
                    'html5' => false,
                ],
                )) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
