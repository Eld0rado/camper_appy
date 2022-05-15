<?php

namespace App\Controller;

use App\Service\CallApiService;
use ArrayObject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    /**
     * Appel à l"api et reccuperation du formulaire pour créer utilisateur
     *
     * @param CallApiService $callApiService
     * @param Request $request
     * @return Response
     */
    #[Route('/inscription', name: 'inscription')]
    public function index(CallApiService $callApiService, Request $request): Response
    {

        $formUser = $this->createFormBuilder()
            ->add('user', TextType::class)
            ->add('pass', PasswordType::class)
            ->add('name', TextType::class)
            ->add(
                'choix',
                ChoiceType::class,
                [
                    'choices' => [
                        'Vacancier' => 1,
                        'Priopriétaire' => 2,
                    ]
                ]
            )
            ->add('submit', SubmitType::class, [
                'label' => 'Inscription',
            ])
            ->getForm();

        /**
         *Test api page inscription
         */

        $formUser->handleRequest($request);
        if ($formUser->isSubmitted() && !$formUser->isEmpty()) {
            $userAdd = $formUser->getNormData()['user'];
            $passAdd = $formUser->getNormData()['pass'];
            $nameAdd = $formUser->getNormData()['name'];

            //  dd($callApiService->registerUserApi($userAdd, $passAdd, $nameAdd));
            if ($formUser->isSubmitted() && $formUser->isValid()) {
                if ($formUser->getNormData()['choix'] == 1) {

                    $ajoutUser = $callApiService->registerUserApi($userAdd, $passAdd, $nameAdd);
                    if ($ajoutUser == true) {
                        setcookie(
                            'USER_TOKENAPI',
                            $ajoutUser,
                            [
                                // 'expires' => time() + 365 * 24 * 3600,
                                'secure' => true,
                                'httponly' => true,
                            ]
                        );
                        return $this->redirectToRoute('app_home');
                    } else {
                        $this->addFlash(
                            'warning',
                            'Impossible de créer l\'utiliisateur ' . $userAdd
                        );
                    }
                } else {
                    $ajoutOwner = $callApiService->registerOwnerApi($userAdd, $passAdd, $nameAdd);
                    if ($ajoutOwner == true) {
                        setcookie(
                            'USER_TOKENAPI',
                            $ajoutOwner,
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
                            'Impossible de créer le propriétaire ' . $userAdd
                        );
                    }
                }
            }
        }

        return $this->render('inscription/index.html.twig', [
            'controller_name' => 'Inscription',
            'formUser' => $formUser->createView(),
        ]);
    }
}
