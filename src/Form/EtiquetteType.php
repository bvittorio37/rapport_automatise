<?php

namespace App\Form;

use App\Entity\Stock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EtiquetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('debutSerie', NumberType::class,[
                'required'=>true,
                'mapped' => false,
                'label' => 'Numéro début de série',
                'constraints'=>[
                    new NotBlank([
                        'message'=> 'Ce champ ne doit pas être vide'
                    ]),
                ],

            ])
            ->add('finSerie', NumberType::class,[
                'required'=>true,
                'mapped' => false,
                'label' => 'Numéro fin de série',
                'constraints'=>[
                    new NotBlank([
                        'message'=> 'Ce champ ne doit pas être vide'
                    ]),
                ],
            ])
            /* ->add('numBobine', NumberType::class,[
                'required'=>false,
                'mapped' => false,
            ]) */
            ->add('reference', TypeTextType::class,[
                'required'=>true,
                'mapped' => false,
                'label' => 'Référrence',
                'constraints'=>[
                    new NotBlank([
                        'message'=> 'Ce champ ne doit pas être vide'
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stock::class,
        ]);
    }
}
