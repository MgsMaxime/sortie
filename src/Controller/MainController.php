<?php

namespace App\Controller;

use App\Form\FiltresAccueilType;
use App\Model\FiltresAccueil;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/accueil', name: 'main_accueil')]
    public function accueil(SortieRepository $sortieRepository, Request $request): Response
    {
        $dateDuJour = new \DateTime('now');
        $sorties =[];

        $filtres = new FiltresAccueil();

        $filtresForm = $this->createForm(FiltresAccueilType::class, $filtres);

        $filtresForm->handleRequest($request);

        if ($filtresForm->isSubmitted() && $filtresForm->isValid()) {

            $sorties = $sortieRepository->findByFilters($filtres, $this->getUser());

        }

        return $this->render('main/accueil.html.twig', [
            'filtresForm' => $filtresForm->createView(),
            'dateDuJour' => $dateDuJour,
            "sorties" => $sorties
        ]);

    }
}
