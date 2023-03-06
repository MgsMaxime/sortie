<?php

namespace App\Form;

use App\Entity\Sortie;
use Doctrine\DBAL\Types\TextType;
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
                'widget'=>'single text'
            ])
            ->add('duree')
            ->add('dateLimiteInscription', DateType::class, [
                'label'=>'First air date : ',
                'html5'=> true,
                'widget'=>'single text'
            ])
            ->add('nbInscriptionsMax')
            ->add('infosSortie')
            ->add('campus', 'text', array(
                'label'=>'Field',
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
