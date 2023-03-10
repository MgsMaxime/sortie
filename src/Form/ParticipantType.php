<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class)
            ->add('prenom', TextType::class)
            ->add('nom', TextType::class)
            ->add('telephone', TextType::class)
            ->add('mail', TextType::class)
            ->add('password', RepeatedType::class,[
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
            ->add('photo_profil', FileType::class, [
                'mapped'=> false,
                'required'=> false,
                'constraints' => [
                    new Image([
                        // 5 megaOctets = 5M
                        'maxSize' => '5000k',
                        // mimesTypes = extensions des fichiers (par défaut image/*)
                        'mimeTypesMessage' => "Format d'image non autorisé !"
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
