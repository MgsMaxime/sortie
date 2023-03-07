<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/participant', name: 'participant_')]
class ParticipantController extends AbstractController
{
    #[Route('/Mon-profil', name: 'Mon_profil')]
    public function MonProfil(): Response
    {
        return $this->render('participant/monProfil.html.twig');
    }
}
