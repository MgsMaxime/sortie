<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label'=>'Nom du lieu',
                'attr' =>[
                    'placeholder'=>'saisissez le nom du lieu'
                ]
            ])
            ->add('rue', TextType::class,[
                'label'=>'Rue',
                'attr'=>[
                    'placeholder'=>'Saisissez la rue du lieu'
                ]
            ])
            //Permet de faire un select des villes déjà prédéfinies
            ->add('ville', EntityType::class, [
                'class'=>Ville::class,
                'choice_label'=>'nom'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
        ]);
    }
}
