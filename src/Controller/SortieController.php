<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\ModifierSortieType;
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

        //Création d'une instance de form lié à une instance de sortie
        $sortieForm = $this->createForm(sortieType::class, $sortie);


        //méthode qui extrait les éléments du formulaire
        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {

            //Sauvegarde en BDD la créaation de l'événement
            $sortieRepository->save($sortie, true);

            $this->addFlash("success", "Sortie Ajouté !");

            //redirige vers la page accueil
            return $this->redirectToRoute('main_accueil', ['id' => $sortie->getId()]);
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

    #[Route('/modifier/{id}', name: 'modifier', requirements: ['id'=>'\d+'])]
    public function modifier(int $id,SortieRepository $sortieRepository, Request $request): Response
    {
        $sortie = new  Sortie();
        $sortie = $sortieRepository->find($id);

        //Création du formulaire modifier sortie
        $sortieForm = $this->createForm(ModifierSortieType::class, $sortie);

        //Méthode qui extrait les éléments du formulaire
        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()){

            //sauvegarde en BDD la modification de l'event
            $sortieRepository->save($sortie, true);;

            $this->addFlash("success","Sortie Modifiée !");

            //redirige vers la page accueil
            return $this->redirectToRoute('sortie_afficher') ;
        }

        return $this->render('sortie/modifier.html.twig', [
            'sortie'=>$sortie,
            'ModfierSortie'=> $sortieForm->createView()
        ]);
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



}
