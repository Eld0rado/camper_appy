<?php

namespace App\Service;

use PhpParser\JsonDecoder;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class CallApiService
{
    //  $url = 'https://localhost:16548';


    /**
     * Appel = l'API
     *
     * @var [type]
     */
    public $apiClient;
    public $sessionToken;

    public function __construct(HttpClientInterface $apiClient)
    {
        $this->httpClient = $apiClient;
    }
    /**
     * Appel de l'API pour enregirestrement d'un vacancier
     *
     * @param string $user
     * @param string $pass
     * @param string $name
     * @return void
     */
    public function  registerUserApi(string $user, string $pass, string $name)
    {

        $response = $this->httpClient->request('POST',  '/user/register', [
            'json' => ['user' => $user, 'pass' => $pass, 'name' => $name],
        ]);

        $response->getContent()[0];

        if (array_key_exists('error', $response->toArray())) {
            $mess = $response->toArray()["error"];
            return false;
        } else {
            $sessionToken = $response->toArray()["token"];
            return $sessionToken;
        }
    }

    /**
     * Appel de l'API pour enregirestrement d'un proprio
     *
     * @param string $user
     * @param string $pass
     * @param string $name
     * @return void
     */
    public function  registerOwnerApi(string $user, string $pass, string $name)
    {

        $response = $this->httpClient->request('POST', '/owner/register', [
            'json' => ['user' => $user, 'pass' => $pass, 'name' => $name],
        ]);

        if (array_key_exists('error', $response->toArray())) {
            $mess = $response->toArray()["error"];
            return false;
        } else {
            $sessionToken = $response->toArray()["token"];
            return $sessionToken;
        }
    }
    /**
     * appek api pour la connexion d'un vacancier
     *
     * @param string $userId
     * @param string $pass
     * @return void
     */
    public function  userLoginApi(string $userId, string $pass)
    {

        $response = $this->httpClient->request('POST', '/user/login', [
            'json' =>
            ['user' => $userId, 'pass' => $pass]
        ]);


        if (array_key_exists('error', $response->toArray())) {
            return false;
        } else {
            $sessionToken = $response->toArray()["token"];
            return $sessionToken;
        }
    }

    /**
     * appek api pour la connexion d'un proprio
     *
     * @param string $userId
     * @param string $pass
     * @return void
     */
    public function  ownerLoginApi(string $userId, string $pass)
    {

        $response = $this->httpClient->request('POST', '/owner/login', [
            'json' =>
            ['user' => $userId, 'pass' => $pass]
        ]);

        if (array_key_exists('error', $response->toArray())) {
            return false;
        } else {
            $sessionToken = $response->toArray()["token"];
            return $sessionToken;
        }
    }

    /**
     * Appel à l'API proprio pour voir ses campings
     * nécéssite user token owner
     * @return void
     */
    public function  ownerCampingsApi()
    {
        $tokenOwner =  $_COOKIE['USER_TOKENAPI'];

        $response = $this->httpClient->request(
            'GET',
            '/campings/me',
            [
                'json' => ['token' => $tokenOwner],
            ]
        );

        if (array_key_exists('error', $response->toArray())) {
            $mess = $response->toArray()["error"];
            // return $mess;
            return false;
        } else {
            $campings = $response->toArray();
            return $campings;
        }
    }

    /**
     *  consultation des campings pour tous utilisateur
     *
     * @return void
     */
    public function userCampingsApi()
    {

        $response = $this->httpClient->request('GET', '/campings');

        $decodedPayload = $response->toArray();
        // dd($response->toArray());
        if ($response->toArray() == null || array_key_exists('error', $response->toArray())) {
            return false;
        } else {
            return $response->toArray();
        }
    }

    /**
     * Création d'un camping - necessite token Owner
     *
     * @param [type] $name
     * @param [type] $desc
     * @param [type] $ville
     * @param [type] $nbBung
     * @param [type] $nbTentes
     * @param [type] $nbCar
     * @return void
     */
    public function createCampingsApi($name, $desc, $ville, $nbBung, $nbTentes, $nbCar)
    {

        $response = $this->httpClient->request('POST', '/campings/create', [
            'json' => [
                'token' => $_COOKIE['USER_TOKENAPI'],
                'coordinates' => ['longitude' => 0, 'latitude' => 0],
                'name' => $name,
                'description' => $desc,
                'city' => $ville,
                'bungalows' => $nbBung,
                'tentPlaces' => $nbTentes,
                'campingcarPlaces' => $nbCar
            ]
        ]);
        // dd($response->toArray());

        if ($response->toArray() == null || array_key_exists('error', $response->toArray())) {
            return false;
        } else {
            //   dd($response->toArray());
            return $response->toArray();
        }
    }

    /**
     * Appel api information d'un camping
     *
     * @param [type] $id
     * @return void
     */
    public function detailCampingsApi($id)
    {

        $response = $this->httpClient->request('GET', '/campings/detail', [
            'json' => [
                'id' => $id,
            ],
        ]);
        if ($response->toArray() == null || array_key_exists('error', $response->toArray())) {
            return false;
        } else {
            return $response->toArray();
        }
    }
}
