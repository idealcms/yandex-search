<?php

declare(strict_types=1);

namespace Ideal\YandexSearch;

interface RequestInterface
{
    /**
     * Получение соответствующего запросу объекта ответа, куда клиент передаст полученные данные
     */
    public function getResponse(): ResponseInterface;

    /**
     * Получение url по которому нужно производить запрос к Яндексу
     */
    public function getUrl(): string;
}
