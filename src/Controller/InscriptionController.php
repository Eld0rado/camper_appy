<?php

namespace App\Controller;

use App\Service\CallApiService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'inscription')]
    public function index(CallApiServicervice $callApiService): Response
    {

        /**
         *Test api page inscription
         */
        dd($callApiService = $callApiService->getApiRegisterToken());
        return $this->render('inscription/index.html.twig', [
            'controller_name' => 'InscriptionController',
        ]);
    }
}
