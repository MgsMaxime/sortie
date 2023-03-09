<?php

namespace App\Controller;

use App\Form\ParticipantType;
use App\Repository\ParticipantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/participant', name: 'participant_')]
class ParticipantController extends AbstractController
{

    #[Route('/profilOrganisateur', name: 'profil_organisateur')]
    public function monProfil(): Response
    {
        return $this->render('participant/profilOrganisateur.html.twig');
    }

    #[Route('/modifier/{id}', name: 'modifier', requirements: ['id' => '\d+'])]
    public function modifierProfil(int $id, ParticipantRepository $participantRepository, Request $request)
    {
        // récupérer le participant grâce à son id
        $participant = $participantRepository->find($id);

        // instance de form liée à une instance de participant
        $participantForm = $this->createForm(participantType::class, $participant);
        // récupérer les données du formulaire
        $participantForm->handleRequest($request);



        // si le formulaire est soumis et valide
        if ($participantForm->isSubmitted() && $participantForm->isValid()) {
            // récupérer les nouvelles données
            $pseudo = $participantForm->get('pseudo')->getData();
            $prenom = $participantForm->get('prenom')->getData();
            $nom = $participantForm->get('nom')->getData();
            $telephone = $participantForm->get('telephone')->getData();
            $mail = $participantForm->get('mail')->getData();
            $password = $participantForm->get('password')->getData();
            $campus = $participantForm->get('campus')->getData();


            // setter les nouvelles données si présente
            $participant->setPseudo($pseudo);
            $participant->setPrenom($prenom);
            $participant->setNom($nom);
            $participant->setTelephone($telephone);
            $participant->setMail($mail);
            if($password != null){
                $participant->setPassword($password);
            }
            $participant->setCampus($campus);

            // sauvegarder les nouvelles données en BDD
            $participantRepository->save($participant, true);
            $this->addFlash('success', 'Profil modifié !');

            // rediriger vers le profil modifié
            return $this->redirectToRoute('participant_modifier', ['id' => $participant->getId()]);
        }

        // afficher le formulaire de modification
        return $this->render('participant/modifierProfil.html.twig', [
            'participantForm' => $participantForm->createView(),
            'participant' => $participant
        ]);
    }

}

