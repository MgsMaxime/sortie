<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    #[Route('/Creation', name: 'sortie.creation')]
    public function creation(): Response
    {
        return $this->render('sortie/creation.html.twig');
    }
}
