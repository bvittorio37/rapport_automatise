<?php

namespace App\Form;

use App\Entity\Rapport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Rapport1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('site')
            ->add('numeroVol')
            ->add('debutService', DateTimeType::class, array(
                'required' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control input-inline datetimepicker',
                   // 'data-provide' => 'datetimepicker',
                    'html5' => false,
                ],
                ))
            ->add('finService', DateTimeType::class, array(
                'required' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control input-inline datetimepicker',
                   // 'data-provide' => 'datetimepicker',
                    'html5' => false,
                ],
                ))
           /*  ->add('datePrevue', DateTimeType::class, array(
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
                )) */
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
