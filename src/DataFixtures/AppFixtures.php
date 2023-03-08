<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Entity\Ville;
use App\Repository\CampusRepository;
use App\Repository\EtatRepository;
use App\Repository\LieuRepository;
use App\Repository\ParticipantRepository;
use App\Repository\VilleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private $managerRegistry;
    private $faker;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
        $this->faker = Factory::create('fr FR');
    }

    public function load(ObjectManager $manager): void
    {
        $this->addEtat($manager);
        $this->addVille($manager);
        $this->addLieu($manager);
        $this->addCampus($manager);
        $this->addParticipant($manager);
        $this->addSorties($manager);
    }

    public function addSorties(ObjectManager $manager){

    $lieurepo = new LieuRepository($this->managerRegistry);
    $campusrepo = new CampusRepository($this->managerRegistry);
    $etatrepo = new EtatRepository($this->managerRegistry);
    $userrepo = new ParticipantRepository($this->managerRegistry);
    $etats = $etatrepo->findAll();
    $lieux = $lieurepo->findAll();
    $campus = $campusrepo->findAll();
    $users = $userrepo->findAll();


    for ($i=0; $i<50; $i++){

        $sortie = new Sortie();

        $sortie->setNom($this->faker->name);
        $sortie->setInfosSortie($this->faker->name);
        $sortie->setDuree($this->faker->randomNumber());
        $sortie->setDateHeureDebut(new \DateTime());
        $sortie->setDateLimiteInscription(new \DateTime('+1month'));
        $sortie->setEtat($this->faker->randomElement($etats));
        $sortie->setLieu($this->faker->randomElement($lieux));
        $sortie->setNbInscriptionsMax($this->faker->randomNumber());
        $sortie->setSiteOrganisateur($this->faker->randomElement($campus));
        $sortie->setOrganisateur($this->faker->randomElement($users));

        $manager->persist($sortie);
        }

        $manager->flush();

    }

    public function addEtat(ObjectManager $manager){

        $possibilities=["Créee", "Ouverte", "Clôturée", 'Activité en cours', "Annulée"];

        for ($i=0; $i<sizeof($possibilities); $i++){

            $etat = new Etat();
            $etat->setLibelle($possibilities[$i]);

            $manager->persist($etat);
        }

    }

    private function addVille(ObjectManager $manager)
    {
        for ($i=0; $i<50; $i++){

            $ville = new Ville();

            $ville->setNom($this->faker->city);
            $ville->setCodePostal($this->faker->randomNumber(5));

            $manager->persist($ville);
        }
        $manager->flush();
    }

    private function addLieu(ObjectManager $manager)
    {
        $villerepo=new VilleRepository($this->managerRegistry);
        $villes=$villerepo->findAll();

        for ($i=0; $i<50; $i++){

            $lieu = new Lieu();

            $lieu->setVille($this->faker->randomElement($villes));
            $lieu->setNom($this->faker->city);
            $lieu->setRue($this->faker->address);
            $lieu->setLatitude($this->faker->latitude);
            $lieu->setLongitude($this->faker->longitude);

            $manager->persist($lieu);
        }
        $manager->flush();
    }

    private function addCampus(ObjectManager $manager)
    {
        $possibilities=["Saint-Herblain", "Niort", "Quimper", 'Chartres-de-Bretagne'];

        for ($i=0; $i<sizeof($possibilities); $i++){

            $campus = new Campus();
            $campus->setNom($possibilities[$i]);

            $manager->persist($campus);
        }
        $manager->flush();
    }

    private function addParticipant(ObjectManager $manager)
    {
        $campusrepo = new CampusRepository($this->managerRegistry);
        $campus = $campusrepo->findAll();

        for ($i=0; $i<100; $i++){

            $participant = new Participant();

            $participant->setNom($this->faker->name);
            $participant->setPrenom($this->faker->name);
            $participant->setMail($this->faker->email);
            $participant->setTelephone($this->faker->phoneNumber);
            $participant->setPassword($this->faker->password);
            $participant->setPseudo($this->faker->userName);
            $participant->setRoles(['ROLE_USER']);
            $participant->setActif($this->faker->boolean());
            $participant->setCampus($this->faker->randomElement($campus));

            $manager->persist($participant);
        }
        $manager->flush();
    }
}
