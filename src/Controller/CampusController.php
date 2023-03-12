<?php

namespace App\Controller;

use App\Repository\CampusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/campus', name: 'campus_')]
class CampusController extends AbstractController
{
    #[Route('/afficher', name: 'afficher')]
    public function afficherCampus(CampusRepository $campusRepository): Response
    {
        $allCampus = $campusRepository->findAll();

        if(!$allCampus){
            throw $this->createNotFoundException("Oups, les campus n'ont pas été trouvés !");
        }

        return $this->render('campus/afficherCampus.html.twig', [
            'allCampus' => $allCampus
        ]);
    }

    #[Route('/filtrer', name: 'filtrer')]
    public function filtrerCampus(CampusRepository $campusRepository): Response
    {
        // TODO : requête personnalisée identique au FiltresAccueilType
        // à créer pour bouton recherche avec 'le nom contient :'
//        $allCampus = $campusRepository->findBy(["nom" => "'%'saisie'%'"]);
//
//        if(!$allCampus){
//            throw $this->createNotFoundException("Oups, les campus n'ont pas été trouvés !");
//        }

        return $this->render('campus/afficherCampus.html.twig', [
//            'allCampus' => $allCampus
        ]);
    }


    #[Route('ajouter/{id}', name: 'ajouter')]
    public function ajouterCampus(){
        // TODO

        return $this->render('campus/afficherCampus.html.twig');
    }

    #[Route('modifier/{id}', name: 'modifier')]
    public function modifierCampus(){
        // TODO

        return $this->render('campus/afficherCampus.html.twig');
    }

    #[Route('supprimer/{id}', name: 'supprimer')]
    public function supprimerCampus(){
        // TODO

        return $this->render('campus/afficherCampus.html.twig');
    }

}
