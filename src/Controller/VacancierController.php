<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VacancierController extends AbstractController
{
    #[Route('/vacancier', name: 'app_vacancier')]
    public function index(): Response
    {
        return $this->render('vacancier/index.html.twig', [
            'controller_name' => 'VacancierController',
        ]);
    }
}
