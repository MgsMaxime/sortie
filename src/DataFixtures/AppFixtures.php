<?php

namespace App\DataFixtures;

use App\Entity\Sortie;
use App\Repository\CampusRepository;
use App\Repository\EtatRepository;
use App\Repository\LieuRepository;
use App\Repository\ParticipantRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr FR');
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

/*            $participant->setNom($faker->name);
            $participant->setPrenom($faker->name);
            $participant->setMail($faker->email);
            $participant->setTelephone($faker->phoneNumber);
            $participant->setPassword($faker->password);
            $participant->setPseudo($faker->userName);
            $participant->setRoles(['ROLE_USER']);
            $participant->setActif($faker->boolean());*/

            $sortie->setNom($faker->name);
            $sortie->setInfosSortie($faker->name);
            $sortie->setDuree($faker->randomNumber());
            $sortie->setDateHeureDebut(new \DateTime());
            $sortie->setDateLimiteInscription(new \DateTime('+1month'));
            $sortie->setEtat($faker->randomElement($etats));
            $sortie->setLieu($faker->randomElement($lieux));
            $sortie->setNbInscriptionsMax($faker->randomNumber());
            $sortie->setSiteOrganisateur($faker->randomElement($campus));
            $sortie->setOrganisateur($faker->randomElement($users));

            $manager->persist($sortie);
        }

        $manager->flush();
    }
}
