<?php

namespace App\Model;

use App\Repository\EtatRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class MajEtatSorties
{

    //Classe en charge de la mise à jour de l'état des sorties en BDD

    public function majEtat(EntityManagerInterface $entityManager, EtatRepository $etatRepository, SortieRepository $sortieRepository)
    {

        $sorties = $sortieRepository->findAll();
        $etat = $etatRepository->findByLibelle("Clôturée");

        foreach ($sorties as $sortie) {

            //Si l'état est "passée" et si cela fait plus d'un mois qu'il l'est
            //DateHeureDebut + durée = limite antérieure
            //limite antérieure + 1 mois = limite postérieure
            //Si dateAujourd'hui > limite postérieure,
            //Alors l'état passe en clôturé

            $dateHeureDebut = $sortie->getDateHeureDebut();
            $limiteAnt = $dateHeureDebut->add(new \DateInterval('PT' . $sortie->getDuree() . 'M'));
            $limitePost = $limiteAnt->add(new \DateInterval('P' . '1' . 'M'));
            $dateAuj = new \DateTime();
            $diff = false;

            if ($dateAuj > $limitePost) $diff = true;

            if ($sortie->getEtat()->getLibelle() == "Passée" && $diff) {
                $sortie->setEtat($etat[0]);
                $sortieRepository->save($sortie);
            }
        }

        $entityManager->flush();
    }

}