<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $campus = new Campus();
        $builder
            ->add('pseudo', TextType::class)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('mail', TextType::class)
            ->add('telephone', TextType::class)
            ->add('plainPassword', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'confirmation incorrecte',
                'required' => false,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmation'],
            ])
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nom'
            ])
            // TODO : ajouter photo de profil (fin itération 1)
            //->add('photoDeProfil')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
