<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Form\LieuType;
use App\Repository\LieuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/lieu', name: 'lieu_')]

class LieuController extends AbstractController
{
    #[Route('/creation/lieu', name: 'creation')]
    public function creationLieu(LieuRepository $lieuRepository, Request $request): Response
    {
        $lieu = new Lieu();

        //Création d'une instance de form lié à une instance de sortie
        $lieuForm = $this->createForm(LieuType::class, $lieu);


        //méthode qui extrait les éléments du formulaire
        $lieuForm->handleRequest($request);

        if ($lieuForm->isSubmitted() && $lieuForm->isValid()) {

            //Sauvegarde en BDD la créaation de l'événement
            $lieuRepository->save($lieu, true);

            $this->addFlash("success", "Lieu Ajouté !");

            //redirige vers la page accueil
            return $this->redirectToRoute('sortie_creation', ['id' => $lieu->getId()]);
        }


        return $this->render('sortie/creationLieu.html.twig', [
            'lieuForm' => $lieuForm->createView()

        ]);
    }
}
