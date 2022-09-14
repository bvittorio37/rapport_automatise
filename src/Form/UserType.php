<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('no_mat')
            ->add('noms')
            ->add('prenoms')
            ->add('email')
            ->add('roles',ChoiceType::class,[
                'multiple' => true,
                'expanded' => true,
                'choices' => [
                    'TECHNICIEN'=> 'ROLE_USER',
                    'GESTIONNAIRE STOCK'=>'ROLE_GESTIONNAIRE_STOCK',
                    'SUPER ADMIN'=> 'ROLE_SUPER_ADMIN',
                    ]
            ]
            )
            ->add('password')
            ;
       
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
        
    }
   
}
