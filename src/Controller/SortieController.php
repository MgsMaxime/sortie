<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sortie', name: 'sortie_')]
class SortieController extends AbstractController
{
    #[Route('/creation', name: 'creation')]
    public function creation(SortieRepository $sortieRepository, Request $request): Response
    {
        $sortie = new Sortie();

        //Création d'une instance de form lié à une instance de série
        $sortieForm = $this->createForm(sortieType::class, $sortie);


        //méthode qui extrait les éléments du formulaire
        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {

            //Sauvegarde en BDD la créaation de l'événement
            $sortieRepository->save($sortie, true);

            $this->addFlash("success", "Sortie Ajouté !");

            //redirige vers la page de détail de la série
            return $this->redirectToRoute('sortie_accueil', ['id' => $sortie->getId()]);
        }


        return $this->render('sortie/creation.html.twig', [
            'sortieForm' => $sortieForm->createView()

        ]);
    }

    #[Route('/afficher', name: 'afficher')]
    public function afficher()
    {
        return $this->render('sortie/afficher.html.twig');
    }

    #[Route('/modifier', name: 'modifier')]
    public function modifier()
    {
        return $this->render('sortie/modifier.html.twig');
    }

    #[Route('/supprimer', name: 'supprimer')]
    public function supprimer()
    {
        return $this->render('sortie/supprimer.html.twig');
    }

    #[Route('/publier', name: 'publier')]
    public function publier()
    {
        return $this->render('sortie/publier.html.twig');
    }

    #[Route('/annuler', name: 'annuler')]
    public function annuler()
    {
        return $this->render('sortie/annuler.html.twig');
    }

    #[Route('/accueil', name: 'accueil')]
    public function accueil()
    {
        return $this->render('accueil.html.twig');
    }
}
