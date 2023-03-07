<?php

namespace App\Controller;

use App\DataFixtures\AppFixtures;
use App\Repository\CampusRepository;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    #[Route('/accueil', name: 'sortie_accueil')]
    public function accueil(SortieRepository $sortieRepository,AppFixtures $fixtures, CampusRepository $campusRepository): Response
    {
        $campus = $campusRepository->findAll();
        $dateDuJour = new \DateTime('now');
        //$fixtures->load($manager);

        $sorties =[];

        if ($_GET){

            //TODO requête parametrée : jointure entre les tables intéressantes et boucle sur les éléments du get
            //pour les intégrer dans la requête

            $qb = $sortieRepository->createQueryBuilder('s');
            $qb
                ->leftJoin('s.etat', 'etat')
                ->addSelect('etat')
                ->leftJoin('s.organisateur', 'orga')
                ->addSelect('orga')
            ;

            /*if (!$_GET["tousLesCampus"]){
                $qb->andWhere("s.siteOrganisateur = getValue()");
            }*/

/*            if ($_GET["checkbox_orga"]) {
                $user = $this->getUser()->getPseudo();
                $qb->andWhere('s.organisateur.pseudo = :pseudo');
                $qb->setParameter('pseudo', $user);
            }*/

/*            if ($_GET["checkbox_inscrit"]){
                $user = $this->getUser()->getPseudo();
                $qb->andWhere('s.organisateur.pseudo = :pseudo');
                $qb->setParameter('pseudo', $user);
            }*/

            $sorties = $qb->getQuery()->getResult();

        }

        return $this->render('/accueil.html.twig',[
            'campus' => $campus,
            'dateDuJour' => $dateDuJour,
            'participant' => $this->getUser(),
            "sorties" => $sorties
        ]);
    }
}
