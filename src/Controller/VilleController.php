<?php

namespace App\Controller;

use App\Entity\Ville;
use App\Repository\VilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ville', name: 'ville_')]
class VilleController extends AbstractController
{
    #[Route('/afficher', name: 'afficher')]
    public function afficherVilles(VilleRepository $villeRepository): Response
    {
        $villes = $villeRepository->findAll();

        if(!$villes){
            throw $this->createNotFoundException("Oups, les villes n'ont pas été trouvées !");
        }

        return $this->render('ville/afficherVilles.html.twig', [
            'villes' => $villes
        ]);
    }

    #[Route('/filtrer', name: 'filtrer')]
    public function filtrerVille(Request $request, VilleRepository $villeRepository): Response
    {
        $saisie = $request->query->get('saisie');

        // TODO : gérer les exceptions 404
        if(empty($saisie)){
            return $this->redirectToRoute('ville_afficher');
        }

        $villes = $villeRepository->createQueryBuilder('v')
            ->where('v.nom LIKE :nom')
            ->setParameter('nom', '%'.$saisie.'%')
            ->orderBy('v.nom', 'ASC')
            ->getQuery()
            ->getResult();

        if(empty($villes)){
            // TODO : gérer les exceptions 404
            // throw $this->createNotFoundException("Oups, aucune ville n'a été trouvée !");
            // à remplacer par message +
            return $this->redirectToRoute('ville_afficher');
        }

        return $this->render('ville/afficherVilles.html.twig', [
            'villes' => $villes,
            'saisie' => $saisie
        ]);
    }

    #[Route('ajouter/{id}', name: 'ajouter')]
    public function ajouterVille(VilleRepository $villeRepository, Request $request): Response
    {
        // TODO : function ajouterVille() avec exception
        $ville = new Ville();


        return $this->render('ville/afficherVilles.html.twig');
    }

    #[Route('modifier/{id}', name: 'modifier')]
    public function modifierVille(VilleRepository $villeRepository, Request $request): Response
    {
        // TODO : function modifierVille() avec exception

        return $this->render('ville/afficherVilles.html.twig');
    }

    #[Route('supprimer/{id}', name: 'supprimer')]
    public function supprimerVille(VilleRepository $villeRepository, Request $request): Response
    {
        // TODO : function supprimerVille() avec exception

        return $this->render('ville/afficherVilles.html.twig');
    }
}
