<?php

namespace App\Form;

use App\Entity\Rapport;
use App\Entity\Site;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotNullValidator;

class RapportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('site', EntityType::class, [
                'placeholder' => 'Choisir le Site',
                'required'=> false,
                'class' => Site::class,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            /* ->add('numeroVol') */
            ->add('debutService', DateTimeType::class, array(
                'required' => true,
                'widget' => 'single_text',
                /* 'constraints' => [new NotNull([
                    'message' => 'Aucun matériel séléctionné! ',
                ]),new NotBlank()], */
                'attr' => [
                    'class' => 'form-control input-inline datetimepicker',
                   // 'data-provide' => 'datetimepicker',
                    'html5' => false,
                ],
                ))
            ->add('finService', DateTimeType::class, array(
                'required' => true,
                'widget' => 'single_text',
                /* 'constraints'=>[
                    new NotNull(['message'=> 'Ce champ est obligatoir'

                    ]),
                ], */
                'attr' => [
                    'class' => 'form-control input-inline datetimepicker',
                   // 'data-provide' => 'datetimepicker',
                    'html5' => false,
                ],
                ))
            /* ->add('datePrevue', DateTimeType::class, array(
                'required' => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control input-inline datetimepicker',
                    // 'data-provide' => 'datetimepicker',
                    'html5' => false,
                ],
                ))
            ->add('dateVol', DateTimeType::class, array(
                'required' => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control input-inline datetimepicker',
                    // 'data-provide' => 'datetimepicker',
                    'html5' => false,
                ],
                ))*/
             ->add('visaParRapports', CollectionType::class, [
                'entry_type' => VisaRapportType::class,
                'entry_options' => ['label' => false],
                //'allow_add' => true,
                'by_reference' => false,
            ])  
            ->add('remarque')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rapport::class,
        ]);
    }
}
