<?php

namespace App\Form;

use App\Entity\Materiel;
use App\Entity\Stock;
use App\Entity\Unite;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\DBAL\Types\TextType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockType extends AbstractType
{
    private $doctrine;
    public function __construct(ManagerRegistry $doctrine)
    {
      $this->doctrine =$doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder

             ->add('unite', EntityType::class, [
                'required'=>true,
                'mapped' => false,
                'placeholder' => 'Choisir son unite',
                
                'class' => Unite::class,
                'choice_label' => function(Unite $unite) {
                    return sprintf(' %s', $unite->getUnite());
                },
                'attr' => [
                    'class' => 'form-control',
                ],
            ])   
            ->add('quantite', NumberType::class,[
                'required'=>true,
                'mapped' => false,
                'label'=>'Quantité'
            ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stock::class,
        ]);
    }
}
  /*   public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
            ->add('intitule',TypeTextType::class,[
                'required'=>false,
            ])
            ->add('materiel', EntityType::class, [
                'required'=>true,
                'class' => Materiel::class,
                'placeholder' => 'Sélectionnez un materiel',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])  */
            /* ->add('unite', EntityType::class, [
                'required'=>true,
                'mapped' => false,
                'placeholder' => 'Choisir son unite',
                'class' => Unite::class,
                'choice_label' => function(Unite $unite) {
                    return sprintf(' %s', $unite->getUnite());
                },
                'attr' => [
                    'class' => 'form-control',
                ],
            ])   
            ->add('entree')
            ->add('debutSerie')
            ->add('finSerie')
            ->add('reference')
            ->add('intitule')  */ 
            /* ->addEventListener( FormEvents::PRE_SUBMIT,
            [$this, 'modifierForm'])
            ->getForm(); 
       ;
        
        
    }
    

    public function modifierForm(FormEvent $event): void
    {
        $forms= $event->getForm();
       $materiel= $this->doctrine->getRepository(Materiel::class)->find($event->getData()['materiel']) ;
       //dd($materiel);
        if($materiel->getMateriel()==="Etiquette"){
            $forms->add('debutSerie')
            ->add('finSerie')
            ->add('reference');
        }
        else{
            $forms->add('unite', EntityType::class, [
                'required'=>true,
                'mapped' => false,
                'placeholder' => 'Choisir son unite',
                'class' => Unite::class,
                'choice_label' => function(Unite $unite) {
                    return sprintf(' %s', $unite->getUnite());
                },
                'attr' => [
                    'class' => 'form-control',
                ],
            ])   
            ->add('entree');
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stock::class,
        ]);
    }*/