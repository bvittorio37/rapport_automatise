<?php

namespace App\Form;

use App\Entity\Materiel;
use App\Entity\Unite;
use App\Entity\UniteMateriel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterielType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categorie')
            ->add('materiel')
            /* ->add('uniteMateriel', EntityType::class, [
                'required'=>false,
                'class' => UniteMateriel::class,
                'choice_label' => function(Unite $unite) {
                    return sprintf(' %s', $unite->getUnite());
                },
                'attr' => [
                    'class' => 'form-control',
                ],
            ]) */
            /* ->add('nouvelUnite', TextType::class, [
                'required'=>false,
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])  */
            
            ->add('uniteMateriels', CollectionType::class, [
                'entry_type' => UniteMaterielType::class,
                'entry_options' => ['label' => false],
                //'allow_add' => true,
                'by_reference' => false,
            ])   
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Materiel::class,
        ]);
    }
}
