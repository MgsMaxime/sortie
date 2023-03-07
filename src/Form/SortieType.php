<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('dateHeureDebut', DateType::class, [
                'label'=>'First air date : ',
                'html5'=> true,
                'widget'=>'single_text'
            ])
            ->add('duree')
            ->add('dateLimiteInscription', DateType::class, [
                'label'=>'First air date : ',
                'html5'=> true,
                'widget'=>'single_text'
            ])
            ->add('nbInscriptionsMax')
            ->add('infosSortie')
            ->add('siteOrganisateur', EntityType::class, array(
                'class' => Campus::class,
                'label'=>'Campus',
                'empty_data'=>'default value'
            ))
            ->add('organisateur')
            ->add('participants')
            ->add('lieu')
            ->add('etat')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
