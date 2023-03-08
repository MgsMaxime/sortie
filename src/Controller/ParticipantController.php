<?php

namespace App\Controller;

use App\Repository\ParticipantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/participant', name: 'participant_')]
class ParticipantController extends AbstractController
{
    #[Route('/Mon-profil', name: 'Mon_profil')]
    public function MonProfil(ParticipantRepository $participantRepository): Response
    {
        $user = $this->getUser();
        //TODO :récup du campus
        $campus = $user->getCampus()->getNom();
        dd($campus);

         $qb = $participantRepository->createQueryBuilder('p');

            $qb
                // jointure sur campus dans tables sortie et campus
                ->leftJoin('p.site_organisateur', 'camp')
                ->addSelect('campus');
//                // jointure sur participant dans tables sortie et participant
//                ->leftJoin('s.participant', 'part')
//                ->addSelect('part')
//                ->andWhere(':user MEMBER OF s.participants');
//                ->setParameter('user', $user);
        $user = $qb->getQuery()->getResult();


        return $this->render('participant/monProfil.html.twig',[
            'user' => $user,
            'campus' => $campus
        ]);

    }
}
