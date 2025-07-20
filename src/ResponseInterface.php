<?php

declare(strict_types=1);

namespace Ideal\YandexSearch;

interface ResponseInterface
{
    /**
     * Инициализация объекта ответа данными, полученными от Яндекса
     */
    public function setXml(\SimpleXMLElement $xml): self;

    /**
     * Получение списка найденных документов
     *
     * @return array<Document>
     */
    public function getDocuments(): array;

    /**
     * Получение количества найденных документов
     */
    public function getDocsTotal(): int;
}
