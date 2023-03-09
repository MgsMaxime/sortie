<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'label'=>'Nom de la sortie',
                'attr'=>[
                    'placeholder'=>'Saisissez un nom pour la sortie'
                ]
            ])
            ->add('dateHeureDebut', DateTimeType::class, [
                'label' => 'Date et Heure de la sortie : ',
                'html5' => true,
                'widget' => 'single_text',
                'attr'=> [
                    'class'=>'datetimepicker'
                ]
            ])
            ->add('duree', TextType::class, [
                'label' => 'Durée',
                'attr'=>[
                    'placeholder' => 'Saisissez la durée de la sortie'
                ]
            ])
            ->add('dateLimiteInscription', DateType::class, [
                'label' => "Date limite d'inscription : ",
                'html5' => true,
                'widget' => 'single_text',
            ])
            ->add('nbInscriptionsMax', TextType::class,[
                'label'=>'Nombres de places :',
                'attr' => [
                    'placeholder'=>'Saisissez le nombre de places disponibles'
                ]
            ])
            ->add('infosSortie', TextareaType::class, [
                'label'=> 'Description et infos:',
                'attr'=> [
                    'placeholder'=>'Veuillez rentrer les détails de la sortie'
                ]
            ])
            ->add('siteOrganisateur', EntityType::class, [
                    'class' => Campus::class,
                    'label' => 'campus',
                    'choice_label' => 'nom'
                ]

            )
            ->add('organisateur', EntityType::class, [
                'class' => Participant::class,
                'choice_label' => 'nom'
            ])
//            ->add('participants', EntityType::class, [
//                'class' => Participant::class
//            ])
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'nom'
            ])
            ->add('etat', EntityType::class,
                [
                    'class' => Etat::class,
                    'choice_label' => 'libelle'
                ]

            );
            //Bouton enregistrer
//            ->add('save', SubmitType::class, [
//                'label'=> 'Enregistrer',
//                'attr'=>[
//                    'class' => 'btn btn-primary'
//                ]
//            ])
            //Bouton annuler
//            ->add('cancel',SubmitType::class, [
//                'label'=>'Annuler',
//                'attr'=>[
//                    'class' => 'btn btn-secondary',
//                    'formnovalidate'=>'formnovalidate'
//                ]
//            ])
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
