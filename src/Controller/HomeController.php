<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {

        $usr = new Utilisateur();
        $usr->setNom("Jean");
        $usr->setPrenom("Jacques");
        $usr->setEmail("jeanjacques@jj.fr");
        $usr->setRole("Particulier");


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'user' => $usr->getNom(),
        ]);
    }
}
