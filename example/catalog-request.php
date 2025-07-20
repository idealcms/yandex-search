<?php
require_once '../vendor/autoload.php';

use Ideal\YandexSearch\WebSearchRequest;
use Ideal\YandexSearch\Client;

try {
    $request = (new WebSearchRequest('поисковый запрос'))
        ->setPerPage(10)
        ->setPage(0)
    ;

    $client = new Client(
        'https://searchapi.api.cloud.yandex.net',
        'your-api-key',
        $logger,
    );
    $response = $client->send($request);

    foreach ($response->getDocuments() as $result) {
        echo $result->url;
        echo $result->domain;
        echo $result->title;
        echo $result->passage;
    }
} catch (\RuntimeException $e) {
    echo "\nВозникло исключение во время выполнения запроса:\n";
    echo $e->getMessage() . "\n";
} catch (\Throwable $e) {
    echo "\nВозникло неизвестное исключение:\n";
    echo $e->getMessage() . "\n";
}

/**
 * Возвращает массив с результатами
 *
 * $results является массивом
 * Каждый элемент содержит поля:
 *  - url
 *  - domain
 *  - title
 *  - headline
 *  - passages
 */
$results = $response->getDocuments();

/**
 * Возвращает integer с общим количеством страниц результатов
 */
$pages = $response->getDocsTotal();
