<?php 

require 'vendor/autoload.php';

$params = [
    'index' => 'art',
    'type' => 'cms',
    'id' => 'id',
    'body' => ['title' => '*']
];

$client = Elasticsearch\ClientBuilder::create()->build();
$response = $client->index($params);
print_r($response);

