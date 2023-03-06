<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Provider\DateTime;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr FR');
        $sortie = new Sortie();
        $participant = new Participant();
        $etat = new Etat();
        $lieu = new Lieu();
        $ville = new Ville();
        $campus = new Campus();

        for ($i=0; $i<50; $i++){
            $participant->setNom($faker->name);
            $participant->setPrenom($faker->name);
            $participant->setMail($faker->email);
            $participant->setTelephone($faker->phoneNumber);
            $participant->setPassword($faker->password);
            $participant->setPseudo($faker->userName);
            $participant->setRoles(['ROLE_USER']);
            $participant->setActif($faker->boolean());

            $manager->persist($participant);

            $ville->setNom($faker->randomElement(['Saint Herblain', 'Chartres de Bretagne', 'Quimper', 'Niort']));
            $ville->setCodePostal($faker->numberBetween(00001,99999));
            $etat->setLibelle($faker->randomElement(['En cours', 'Fermé', 'Ouvert', 'En création']));
            $lieu->setNom($faker->randomElement(['Patinoire', 'Laser game', 'Bowling', 'Escape Game', 'Piscine', 'Bar', 'BK', 'Cinema']));
            $lieu->setRue($faker->name);
            $lieu->setVille($ville);

            $manager->persist($lieu);

            $campus->setNom($faker->randomElement(['Saint Herblain', 'Chartres de Bretagne', 'Quimper', 'Niort']));

            $sortie->setNom($faker->name);
            $sortie->setInfosSortie($faker->name);
            $sortie->setDuree($faker->randomNumber());
            $sortie->setDateHeureDebut(new \DateTime());
            $sortie->setDateLimiteInscription(new \DateTime('+1month'));
            $sortie->setEtat($etat);
            $sortie->setLieu($lieu);
            $sortie->setNbInscriptionsMax($faker->randomNumber());
            $sortie->setSiteOrganisateur($campus);
            $sortie->setOrganisateur($participant);

            $manager->persist($sortie);
        }

        $manager->flush();
    }
}
