<?php 

require 'vendor/autoload.php';

$client = Elasticsearch\ClientBuilder::create()->build();



$params = [
    'index' => 'art',
    'type' => 'cms',
    'body' => [
        'query' => [
            'match' => [
                'title' => '宝宝'
            ]
        ]
    ]
];

$response = $client->search($params);
print_r($response);
