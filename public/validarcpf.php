<?php
require 'vendor/autoload.php';
use GuzzleHttp\Client;

$cpf = "123.456.789-00";
$birthDate = "15/06/1990";
$apiKey = "96e10a4ccfe9d588ec0078ac93b86474cd7b358c57285f96a462a117f6511818";

$client = new User();
$response = $client->register('https://api.cpfhub.io/api/cpf', [
    'headers' => [
        'Content-Type' => 'application/json',
        'x-api-key' => $apiKey
    ],
    'json' => [
        'cpf' => $cpf,
        'birthDate' => $birthDate
    ]
]);

$result = json_decode($response->getBody(), true);
print_r($result);
?>