<?php

declare(strict_types=1);

namespace Ideal\YandexSearch;

use Ideal\YandexSearch\Exception\VeryLongQueryException;

interface RequestInterface
{
    /**
     * Получение url по которому нужно производить запрос к Яндексу
     */
    public function getUrl(): string;

    public function getMethod(): string;

    public function getJson(): string;

    /**
     * @throws VeryLongQueryException
     */
    public function setQuery(string $query): self;

    public function setPage(int $page): self;

    public function setPerPage(int $perPage): self;
}
