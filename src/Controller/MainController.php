<?php

namespace App\Controller;

use App\Form\FiltresAccueilType;
use App\Model\FiltresAccueil;
use App\Model\MajEtatSorties;
use App\Repository\CampusRepository;
use App\Repository\EtatRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/accueil', name: 'main_accueil')]
    public function accueil(EntityManagerInterface $entityManager, EtatRepository $etatRepository, MajEtatSorties $etatSorties, SortieRepository $sortieRepository, Request $request): Response
    {
        $dateDuJour = new \DateTime('now');
        $sorties =[];
        $maj = false;

        $filtres = new FiltresAccueil();

        $filtresForm = $this->createForm(FiltresAccueilType::class, $filtres);

        $filtresForm->handleRequest($request);

        if ($filtresForm->isSubmitted() && $filtresForm->isValid()) {

            $sorties = $sortieRepository->findByFilters($filtres, $this->getUser());

            if (!$maj){
                $etatSorties->majEtat($entityManager,$etatRepository,$sortieRepository);
                $maj = true;
            }

        }

        return $this->render('main/accueil.html.twig', [
            'filtresForm' => $filtresForm->createView(),
            'dateDuJour' => $dateDuJour,
            "sorties" => $sorties
        ]);

    }
}
