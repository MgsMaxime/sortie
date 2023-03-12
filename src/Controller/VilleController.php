<?php

namespace App\Controller;

use App\Repository\VilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ville', name: 'ville_')]
class VilleController extends AbstractController
{
    #[Route('/afficher', name: 'afficher')]
    public function afficherVilles(VilleRepository $villeRepository): Response
    {
        $villes = $villeRepository->findAll();
        // à créer pour bouton recherche avec 'le nom contient :'

        //$sorties = $sortieRepository->findBy(["nom" => "'%'saisie'%'"]);


        if(!$villes){
            throw $this->createNotFoundException("Oups, les villes n'ont pas été trouvées !");
        }

        return $this->render('ville/afficherVilles.html.twig', [
            'villes' => $villes
        ]);
    }

    #[Route('/filtrer', name: 'filtrer')]
    public function filtrerVille(VilleRepository $villeRepository): Response
    {
        // TODO : requête personnalisée identique au FiltresAccueilType
        // à créer pour bouton recherche avec 'le nom contient :'
//        $villes = $villeRepository->findBy(["nom" => "'%'saisie'%'"]);
//
//        if(!$villes){
//            throw $this->createNotFoundException("Oups, les villes n'ont pas été trouvées !");
//        }

        return $this->render('ville/afficherVilles.html.twig', [
//            'villes' => $villes
        ]);
    }


    #[Route('ajouter/{id}', name: 'ajouter')]
    public function ajouterVille(){
        // TODO

        return $this->render('ville/afficherVilles.html.twig');
    }

    #[Route('modifier/{id}', name: 'modifier')]
    public function modifierVille(){
        // TODO

        return $this->render('ville/afficherVilles.html.twig');
    }

    #[Route('supprimer/{id}', name: 'supprimer')]
    public function supprimerVille(){
        // TODO

        return $this->render('ville/afficherVilles.html.twig');
    }
}
