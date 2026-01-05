<?php

declare(strict_types=1);

namespace Ideal\YandexSearch;

use Ideal\YandexSearch\Exception\VeryLongQueryException;

class WebSearchRequest implements RequestInterface
{
    /** Адрес метода API для поиска */
    protected string $url = '/v2/web/search';

    /** Текст поискового запроса. Текст должен быть оформлен в соответствии с RFC 3986 */
    protected string $query;

    /** Номер страницы поисковой выдачи. Нумерация страниц начинается с нуля */
    protected int $page = 0;

    /** Число позиций на странице выдачи, может принимать значения от 1 до 100 */
    protected int $perPage = 10;

    protected string $method = 'POST';

    /**
     * @throws VeryLongQueryException
     */
    public function __construct(string $query)
    {
        $this->setQuery($query);
    }

    public function setQuery(string $query): self
    {
        if (mb_strlen($query) > 400) {
            throw new VeryLongQueryException('Длина поискового запроса больше 400 символов.');
        }

        $this->query = $query;

        return $this;
    }

    public function setPage(int $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function setPerPage(int $perPage): self
    {
        $this->perPage = $perPage;

        return $this;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    /** @inheritDoc */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @throws \JsonException
     */
    public function getJson(): string
    {
        if (!isset($this->query) || $this->query === '') {
            throw new \InvalidArgumentException('Не указан текст запроса');
        }

        return json_encode([
            'query' => [
                'searchType' => 'SEARCH_TYPE_RU',
                'queryText' => $this->query,
                'familyMode' => 'FAMILY_MODE_NONE',
                'page' => $this->page,
                'fixTypoMode' => 'FIX_TYPO_MODE_ON',
            ],
            'groupSpec' => [
                'groupMode' => 'GROUP_MODE_FLAT',
                'groupsOnPage' => $this->perPage,
            ],
        ], JSON_THROW_ON_ERROR | JSON_INVALID_UTF8_IGNORE);
    }
}
