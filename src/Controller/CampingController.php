<?php

namespace App\Controller;

use App\Entity\Camping;
use App\Repository\CampingRepository;
use App\Service\CallApiService;
use Doctrine\DBAL\Types\TextType as TypesTextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Twig\Node\TextNode;

class CampingController extends AbstractController
{
    /**
     * Appel à l'api et affichage des camping du propriétaire 
     *
     * @param CallApiService $callApiService
     * @return void
     */
    #[Route('/mescampings', name: 'camp_mes')]
    public function mescampings(CallApiService $callApiService)
    {
        if (!array_key_exists('USER_TOKENAPI', $_COOKIE)) {
            return  $this->redirectToRoute('inscription');
            if (empty($_COOKIE['USER_TOKENAPI'])) {
                return $this->redirectToRoute('connexion');
            }
        }
        $mescampings = $callApiService->ownerCampingsApi();
        if (empty($mescampings)) {
            return $this->redirectToRoute('camp_ajout');
        }

        return $this->render('camping/mescampings.html.twig', [
            'campings' => $mescampings,
        ]);
    }
    /**
     * Appel de l'api et réccupération formulaire pour l'ajout d'un camping
     *
     * @param Request $request
     * @param CallApiService $callApiService
     * @return Response
     */
    #[Route('/camping/ajout', name: 'camp_ajout')]
    public function ajouterCamp(Request $request, CallApiService $callApiService): Response
    {
        if (!array_key_exists('USER_TOKENAPI', $_COOKIE)) {
            return  $this->redirectToRoute('inscription');
            if (empty($_COOKIE['USER_TOKENAPI'])) {
                return $this->redirectToRoute('connexion');
            }
        }
        $campForm = $this->createFormBuilder()
            ->add(
                'nomCamping',
                TextType::class,
                ['label' => 'Nom du Camping ']
            )
            ->add(
                'nbBungalow',
                TextType::class,
                ['label' => 'Nombre de Bungalows ']
            )
            ->add(
                'nbTentes',
                TextType::class,
                ['label' => 'Nombre de Tentes ']
            )
            ->add(
                'nbCar',
                TextType::class,
                ['label' => 'Places de CampingCar ']
            )
            ->add(
                'ville',
                TextType::class,
                ['label' => 'Ville ']
            )

            ->add(
                'desc',
                TextareaType::class,
                ['label' => 'Description ']
            )
            ->add('submit', SubmitType::class, [
                'label' => 'Nouveau camp',
            ])
            ->getForm();



        $campForm->handleRequest($request);


        if ($campForm->isSubmitted() && $campForm->isValid()) {
            // $lat = $campForm->getNormData()['lat'];
            // $long = $campForm->getNormData()['long'];
            $name = $campForm->getNormData()['nomCamping'];
            $desc = $campForm->getNormData()['desc'];
            $ville = $campForm->getNormData()['ville'];
            $nbBung = $campForm->getNormData()['nbBungalow'];
            $nbTentes = $campForm->getNormData()['nbTentes'];
            $nbCar = $campForm->getNormData()['nbCar'];
            $ajoutCamp = $callApiService->createCampingsApi($name, $desc, $ville, $nbBung, $nbTentes, $nbCar);
            //dd($campForm->getNormData());
            if ($ajoutCamp == true) {
                return $this->redirectToRoute('camp_mes');
            } else {
                $this->addFlash(
                    'warning',
                    'Impossible de créer le camping '
                );
            }
        }
        return $this->render('camping/ajout.html.twig', [
            'controller_name' => 'Ajout d\'un camping',
            'formCamp' => $campForm->createView(),
        ]);
    }

    /**
     * se rendre sur une page détail camping
     */
    #[Route('/camping/{id}', name: 'camp_detail')]
    public function campingDetail(Request $request, CallApiService $callApiService, string $id,): Response
    {

        $camping[] = $callApiService->detailCampingsApi($id);
        return $this->render('camping/detail.html.twig', [
            'camping' => $camping,
        ]);
    }

    #[Route('/camping/map', name: 'camp_map')]
    public function map()
    {
        return $this->render('camping/map.html.twig');
    }
}
