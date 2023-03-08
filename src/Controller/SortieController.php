<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\SortieRepository;
use App\DataFixtures\AppFixtures;
use App\Repository\CampusRepository;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sortie', name: 'sortie_')]
class SortieController extends AbstractController
{
    #[Route('/accueil', name: 'accueil')]
    public function accueil(SortieRepository $sortieRepository, EntityManagerInterface $manager, AppFixtures $fixtures, CampusRepository $campusRepository): Response
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
                //->leftJoin('s.participants', 'part')
                ->addSelect('orga')
                //->addSelect('part')
            ;

/*            if (!isset($_GET["tousLesCampus"])){
                $campus = $_GET["select_campus"];
                $qb->andWhere("s.siteOrganisateur = $campus");
            }*/

            if (isset($_GET["checkbox_orga"])) {
                $user = $this->getUser();
                $qb->andWhere('s.organisateur = :user');
                $qb->setParameter('user', $user);
            }


            //LA JOINTURE ENTRE LES TABLES SORTIE ET PARTICIPANT DECLENCHE UNE ERREUR
            //UNDEFINED ARRAY KEY "NAME"
/*            if (isset($_GET["checkbox_inscrit"])){
                $user = $this->getUser();

               $qb2 = $sortieRepository->createQueryBuilder('s');
                $qb2
                    ->leftJoin('s.participants', 'part')
                    ->addSelect('part');

                dd($qb2->getQuery()->getResult());

                $qb->andWhere(':user MEMBER OF s.participants');
                $qb->setParameter('user', $user);
            }*/


            if (isset($_GET["checkbox_old"])) {
                $qb->andWhere('s.dateLimiteInscription < :date');
                $qb->setParameter('date', $dateDuJour);
            }

            $sorties = $qb->getQuery()->getResult();

        }

        return $this->render('/accueil.html.twig', [
            'campus' => $campus,
            'dateDuJour' => $dateDuJour,
            'participant' => $this->getUser(),
            "sorties" => $sorties
        ]);
    }

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



}
