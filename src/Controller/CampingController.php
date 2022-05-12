<?php

namespace App\Controller;

use App\Entity\Camping;
use App\Repository\CampingRepository;
use Doctrine\DBAL\Types\TextType as TypesTextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Twig\Node\TextNode;

class CampingController extends AbstractController
{
    #[Route('/camping', name: 'camping')]
    public function index(): Response
    {

        $camp = new Camping();
        $camp2 = new Camping();
        $camp3 = new Camping();
        $camp4 = new Camping();

        $camp->setNomCamping("Grand de l'Est");
        $camp->setInformation("2 pas du centre ville");
        $camp2->setNomCamping("La France de l'Ile");
        $camp2->setSecteur("Vosges");
        $camp3->setNomCamping("Bourg en Lux");
        $camp4->setNomCamping("Bourg en Lux");

        $ae = array($camp, $camp2, $camp3, $camp4);
        //  list($ae);
        return $this->render('camping/index.html.twig', [
            'controller_name' => 'CampingController',
            'list' => $ae,
        ]);
    }

    #[Route('/camping/ajout', name: 'camp_ajout')]
    public function ajouterCamp(Request $request): Response
    {
        $camping = new Camping();
        // $campForm = $this->createForm(CampingRepository::class, $camping);
        $campForm = $this->createFormBuilder()
            ->add('nomCamping', TextType::class)
            ->add('nbBungalow', TextType::class)
            ->add('nbTentes', TextType::class)
            ->add('secteur', TextType::class)
            ->add('information', TextType::class)
            ->add('submit', SubmitType::class, [
                'label' => 'créer',
            ])
            ->getForm();
        $campForm->handleRequest($request);
        //  list($ae);
        return $this->render('camping/ajout.html.twig', [
            'controller_name' => 'Ajout d\'un camping',
            'formCamp' => $campForm->createView(),
        ]);
    }
}
