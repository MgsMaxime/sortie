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
        $ville = $villeRepository->findAll();

        if(!$ville){
            throw $this->createNotFoundException("Oups ! Les villes n'ont pas été trouvée !");
        }
        return $this->render('ville/afficherVilles.html.twig', [
            'ville' => $ville
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
