<?php
namespace App;

use GuzzleHttp\Client;

class Validarcpf
{
    private string $apiKey;
    private Client $client;
    private string $apiUrl = 'https://api.cpfhub.io/cpf/';

    public function __construct()
    {
        $this->apiKey = '96e10a4ccfe9d588ec0078ac93b86474cd7b358c57285f96a462a117f6511818';
        $this->client = new Client();
    }

    public function validar(string $cpf, string $birthDate): array
    {
        try {
            $url = $this->apiUrl . $cpf;
            $response = $this->client->get($url, [
                'headers' => [
                    'x-api-key' => $this->apiKey,
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    'cpf' => $cpf,
                    'birthDate' => $birthDate
                ]
            ]);

            $body = json_decode($response->getBody()->getContents(), true);

            if (isset($body['success']) && $body['success'] === true) {
                return [
                    'success' => true,
                    'data' => $body['data'] ?? null
                ];
            }

            return [
                'success' => false,
                'message' => $body['message'] ?? 'CPF inválido ou não encontrado'
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao conectar à API: ' . $e->getMessage()
            ];
        }
    }
}
