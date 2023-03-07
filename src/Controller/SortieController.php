<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    #[Route('/Creation', name: 'sortie.creation')]
    public function creation(SortieRepository $sortieRepository, Request $request): Response
    {
        $sortie = new Sortie();

        //Création d'une instance de form lié à une instance de série
        $sortieForm = $this->createForm(sortieType::class, $sortie);

        //méthode qui extrait les éléments du formulaire
        $sortieForm->handleRequest($request);

        //Sauvegarde en BDD la créaation de l'événement
        $sortieRepository->save($sortie, true);

        $this->addFlash("success", "Sortie Ajouté !");
        return $this->render('sortie/creation.html.twig', [
            'sortieForm' => $sortieForm->createView()

        ]);
    }
}
