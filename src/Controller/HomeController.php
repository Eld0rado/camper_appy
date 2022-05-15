<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Service\CallApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{


    #[Route('/', name: 'app_home')]
    public function index(CallApiService $callApiService): Response
    {

        $campings = $callApiService->userCampingsApi();
        if ($campings == true) {
            foreach ($campings as $key => $camping) {
                //$villes[] = $camping->getContent[]
                $camp = $callApiService->detailCampingsApi($camping['id']);
                if (array_key_exists('city', $camp)) {
                    $villes[] = [$camp['city'], $camp['name'], $camping['id']];
                } else {
                    $villes[] = ['inconnue', $camp['name'], $camping['id']];
                }
            }
        }
        if ($villes == null || empty($villes) || $camping == false) {
            $villes[] = ['Sans', 'campings', 'connus'];
        }
        // dd($villes);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomePage',
            'data' => $villes,
        ]);
    }

    /**
     * Controlle les données renvoyer et appel l'api
     *
     * @param Request $request
     * @param CallApiService $callApiService
     * @return Response
     */
    #[Route('/connexion', name: 'connect')]
    public function connect(Request $request, CallApiService $callApiService): Response
    {

        $connectForm = $this->createFormBuilder()
            ->add('Identifiant', TextType::class, [
                'attr' =>
                ['placeholder' => 'User Id']
            ])
            ->add('Pass', PasswordType::class)
            ->add('submit', SubmitType::class, [
                'label' => 'Connexion',
            ])
            ->getForm();
        $connectForm->handleRequest($request);
        if ($connectForm->isSubmitted() && $connectForm->isValid()) {
            $userId = $connectForm->getNormData()['Identifiant'];
            $pass = $connectForm->getNormData()['Pass'];
            $connexionUser = $callApiService->userLoginApi($userId, $pass);

            if ($connexionUser == true) {
                setcookie(
                    'USER_TOKENAPI',
                    $connexionUser,
                    [
                        // 'expires' => time() + 365 * 24 * 3600,
                        'secure' => true,
                        'httponly' => true,
                    ]
                );
                return $this->redirectToRoute('app_home');
            } elseif ($callApiService->ownerLoginApi($userId, $pass) == true) {
                setcookie(
                    'USER_TOKENAPI',
                    $callApiService->ownerLoginApi($userId, $pass),
                    [
                        // 'expires' => time() + 365 * 24 * 3600,
                        'secure' => true,
                        'httponly' => true,
                    ]
                );
                return $this->redirectToRoute('camp_mes');
            } else {
                $this->addFlash(
                    'warning',
                    'Impossible de vous connecter'
                );
            }
        }
        return $this->render('home/connect.html.twig', [
            'controller_name' => 'HomeController',
            'formConnect' => $connectForm->createView(),
        ]);
    }
}
