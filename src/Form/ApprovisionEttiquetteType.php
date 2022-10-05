<?php

namespace App\Form;

use App\Entity\Paf;
use App\Entity\Stock;
use App\Entity\StockSite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApprovisionEttiquetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('boxPaf', EntityType::class, [
            'required'=>true,
            'mapped' => false,
            'placeholder' => 'Choisir le Box Paf',
            
            'class' => Paf::class,
            'choice_label' => function(Paf $paf) {
                return sprintf(' %s', $paf->getPaf());
            },
            'attr' => [
                'class' => 'form-control',
            ],
        ])
        ->add('numeroBobine', EntityType::class, [
            'required'=>true,
            'mapped' => false,
            'placeholder' => 'Choisir le Numero du Bobine',
            
            'class' => Stock::class,
            'choice_label' => function(Stock $stock) {
                return  $stock->getDebutSerie().' - '.$stock->getFinSerie();
            },
            'attr' => [
                'class' => 'form-control',
            ],
        ])  
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StockSite::class,
        ]);
    }
}
