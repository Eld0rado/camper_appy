<?php

use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{

    private $client;
    public $sessionToken;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    public function getApiRegisterToken(): array
    {
        $response = $this->client->request(
            'POST',
            'http://localhost:16548/user/register'

            // , [
            //  'headers' => [
            //      Accept' => 'application/json',]

            //$response->toArray()["userToken"];
            // 'headers' => [
            //     'Session-Token' => $sessionToken,
            //     //''
            // ],
            // 'body' =>   '{"input": {"states_id": "5"}}'
            // 'query' => [
            //     'user_token' => $userToken,
            // ]

        );

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        return $content;
    }
}
