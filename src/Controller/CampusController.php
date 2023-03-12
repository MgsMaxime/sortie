<?php

namespace App\Controller;

use App\Repository\CampusRepository;
use App\Repository\VilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function filtrerCampus(Request $request, CampusRepository $campusRepository): Response
    {
        $saisie = $request->query->get('saisie');

        // TODO : gérer les exceptions 404
        if(empty($saisie)){
            return $this->redirectToRoute('campus_afficher');
        }

        $allCampus = $campusRepository->createQueryBuilder('v')
            ->where('v.nom LIKE :nom')
            ->setParameter('nom', '%'.$saisie.'%')
            ->orderBy('v.nom', 'ASC')
            ->getQuery()
            ->getResult();

        if(empty($allCampus)){
            // TODO : gérer les exceptions 404
            // throw $this->createNotFoundException("Oups, aucun campus n'a été trouvé !");
            // à remplacer par message +
            return $this->redirectToRoute('campus_afficher');
        }

        return $this->render('campus/afficherCampus.html.twig', [
            'allCampus' => $allCampus,
            'saisie' => $saisie
        ]);
    }

    #[Route('ajouter/{id}', name: 'ajouter')]
    public function ajouterCampus(CampusRepository $campusRepository, Request $request): Response
    {
        // TODO : function ajouterCampus() avec exception 404

        return $this->render('campus/afficherCampus.html.twig');
    }

    #[Route('modifier/{id}', name: 'modifier')]
    public function modifierCampus(CampusRepository $campusRepository, Request $request): Response
    {
        // TODO : function modifierCampus() avec exception 404

        return $this->render('campus/afficherCampus.html.twig');
    }

    #[Route('supprimer/{id}', name: 'supprimer')]
    public function supprimerCampus(CampusRepository $campusRepository, Request $request): Response
    {
        // TODO : supprimerCampus() avec exception 404

        return $this->render('campus/afficherCampus.html.twig');
    }

}
