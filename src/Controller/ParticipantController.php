<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\ParticipantType;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use App\Utils\Uploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/participant', name: 'participant_')]
class ParticipantController extends AbstractController
{

    #[Route('/profilOrganisateur/{id}', name: 'profil_organisateur', requirements: ['id' => '\d+'])]
    public function afficherProfilOrganisateur(int $id, SortieRepository $sortieRepository, Request $request): Response
    {
        // récupérer id de la sortie (id = 116)
        // $sortieOrganisee = $sortieRepository->find($id);
        $sortieOrganisee = $sortieRepository->find($id);
        // dd($sortieOrganisee);

        // récupérer id de l'organisateur de la sortie (id = 73)
        $organisateur = $sortieOrganisee->getOrganisateur();





        return $this->render('participant/profilOrganisateur.html.twig',[
            'organisateur'=> $organisateur
        ]);
    }

    #[Route('/modifier/{id}', name: 'modifier', requirements: ['id' => '\d+'])]
    public function modifierProfil(int $id, ParticipantRepository $participantRepository, Request $request, Uploader $uploader)
    {
        // récupérer le participant grâce à son id
        $participant = $participantRepository->find($id);
        $photo = $participant->getPhotoProfil();

        // instance de form liée à une instance de participant
        $participantForm = $this->createForm(participantType::class, $participant);
        // récupérer les données du formulaire
        $participantForm->handleRequest($request);


        // si le formulaire est soumis et valide
        if ($participantForm->isSubmitted() && $participantForm->isValid()) {

            // upload photo de profil
            /**
             * @var UploadedFile $file
             */
            // upload crée en service
            $file = $participantForm->get('photo_profil')->getData();

            // si non null => upload, sinon appel pseudo.img
            if (!$file) {
                $participant->setPhotoProfil($photo);
            }else {

            // appel de l'uploader
            $newFileName = $uploader->upload(
                $file,
                // récupérer le paramètre de services.yaml
                $this->getParameter('upload_photo_profil'),
                $participant->getPseudo()
            );

            // setter le nouveau nom du fichier uploadé
            $participant->setPhotoProfil($newFileName);
            }

            // sauvegarder les nouvelles données en BDD
            $participantRepository->save($participant, true);
            $this->addFlash('success', 'Profil modifié !');

            // rediriger vers le profil modifié
            return $this->redirectToRoute('participant_modifier', ['id' => $participant->getId()]);
        }

        // afficher le formulaire de modification
        return $this->render('participant/modifierProfil.html.twig', [
            'participantForm' => $participantForm->createView()
        ]);
    }

    // TODO : if Admin = afficher register pour création utilisateur


}

