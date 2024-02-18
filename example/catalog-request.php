<?php
require_once '../vendor/autoload.php';

use Ideal\YandexSearch\CatalogResponse;
use Ideal\YandexSearch\CatalogRequest;
use Ideal\YandexSearch\Client;

try {
    $request = (new CatalogRequest('your-api-key', 'your-search-id'))
        ->setText('название товара на сайте')
        ->setPerPage(10)
        ->setPage(0);

    /** @var CatalogResponse $response */
    $response = Client::send($request);

    foreach ($response->getDocuments() as $result) {
        echo $result->url;
        echo $result->domain;
        echo $result->title;
        echo $result->headline;
        echo sizeof($result->passages);
    }
} catch (\RuntimeException $e) {
    echo "\nВозникло исключение во время выполнения запроса:\n";
    echo $e->getMessage() . "\n";
} catch (Exception $e) {
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
