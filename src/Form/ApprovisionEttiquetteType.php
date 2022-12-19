<?php

namespace App\Form;

use App\Entity\Paf;
use App\Entity\Stock;
use App\Entity\StockSite;
use App\Repository\PafRepository;
use App\Repository\StockRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApprovisionEttiquetteType extends AbstractType
{   
    private $pafRepos;
    private $stockRepo;
    public function __construct(PafRepository $pafRepos, StockRepository $stockRepo)
    {
        $this->pafRepos= $pafRepos;
        $this->stockRepo= $stockRepo;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
        ->add('boxPaf', EntityType::class, [
            'required'=>true,
            'mapped' => false,
            'placeholder' => 'Choisir le Box Paf',
            'class' => Paf::class,
            'choices' => $this->pafRepos
                ->findBy(['site'=> $builder->getData()->getSite()]),
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
            'label' => 'Numéro de la bobine',
            'placeholder' => 'Choisir le Numero de la Bobine',
            'class' => Stock::class,
            'choices' => $this->stockRepo
                ->findBy(['materiel'=> $builder->getData()->getMateriel()
                          ,'dispo'=>true
            ]),
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
