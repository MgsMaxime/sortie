<?php

namespace App\Controller;

use App\DataFixtures\AppFixtures;
use App\Repository\CampusRepository;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{


    #[Route('/accueil', name: 'sortie_accueil')]
    public function accueil(EntityManagerInterface $manager, AppFixtures $fixtures, CampusRepository $campusRepository): Response
    {
        $campus = $campusRepository->findAll();
        $dateDuJour = new \DateTime('now');
        //$fixtures->load($manager);

        if ($_GET){
            //TODO requête parametrée : jointure entre les tables intéressantes et boucle sur les éléments du get
            //pour les intégrer dans la requête
        }

        return $this->render('/accueil.html.twig',[
            'campus' => $campus,
            'dateDuJour' => $dateDuJour,
            'participant' => $this->getUser()
        ]);
    }
}
