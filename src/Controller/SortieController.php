<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\ModifierSortieType;
use App\Form\SortieType;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

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

    #[Route('/{id}', name: 'afficher', requirements: ['id' => '\d+'])]
    public function afficher(int $id, SortieRepository $sortieRepository, ParticipantRepository $participantRepository): Response
    {
        $sortie = $sortieRepository->find($id);
        $participant = $participantRepository->find($id);


        if(!$sortie && $participant){
            throw $this->createNotFoundException("Oops ! Wish not found !");
        }
        dump($sortie );
        dump($participant);
        return $this->render('sortie/afficher.html.twig', [
            'sortie'=> $sortie,
            'participants'=>$participant
        ]);
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
            return $this->redirectToRoute('main_accueil') ;
        }

        return $this->render('sortie/modifier.html.twig', [
            'sortie'=>$sortie,
            'ModifierSortie'=> $sortieForm->createView()
        ]);
    }

    #[Route('/supprimer/{id}', name: 'supprimer')]
    public function supprimer(int $id, SortieRepository $sortieRepository)
    {

        //Récupération de la série
        $sortie = $sortieRepository->find($id);

        if ($sortie){
            //je le supprime
            $sortieRepository->remove($sortie, true);
            $this->addFlash("Warning", "Sortie deleted !");
        }else{
            throw $this->createNotFoundException("This serie can't be deleted !");
        }
        return $this->redirectToRoute('main_accueil');
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

    #[Route('/inscription/{id}', name: 'inscription', requirements: ['id'=>'\d+'])]
    public function inscription(ParticipantRepository $participantRepository, SortieRepository $sortieRepository, Sortie $id)
    {
        $userID = $this->getUser()->getUserIdentifier();

        if ($id->getParticipants()->count() < $id->getNbInscriptionsMax()){
            $id->addParticipant($participantRepository->findByIdentifier($userID));
            $sortieRepository->save($id, true);
        } else {
            $this->addFlash("Warning", "Nombre d'inscrits maximum atteint !");
        }

        return $this->redirectToRoute("main_accueil");
    }

    #[Route('/desinscription/{id}', name: 'desinscription', requirements: ['id'=>'\d+'])]
    public function desinscription(ParticipantRepository $participantRepository, SortieRepository $sortieRepository, Sortie $id)
    {
        $userID = $this->getUser()->getUserIdentifier();
        $user = $participantRepository->findByIdentifier($userID);

        if ($id->getParticipants()->contains($user)){
            $id->removeParticipant($user);
            $sortieRepository->save($id, true);
        } else {
            $this->addFlash("Warning", "Vous n'êtes pas inscrit à cette sortie !");
        }

        return $this->redirectToRoute("main_accueil");
    }


}
