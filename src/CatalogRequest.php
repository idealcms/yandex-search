<?php

declare(strict_types=1);

namespace Ideal\YandexSearch;

class CatalogRequest implements RequestInterface
{
    /** Base url to service */
    protected string $baseUrl = 'https://catalogapi.site.yandex.net/v1.0';

    /** Ключ для доступа к поиску https://yandex.ru/dev/site/doc/ru/concepts/access */
    protected string $apiKey;

    /** Идентификатор поиска. Чтобы узнать идентификатор, выберите поиск на странице "Мои поиски" */
    protected int $searchId;

    /** Текст поискового запроса. Текст должен быть оформлен в соответствии с RFC 3986 */
    protected string $text;

    /** Номер страницы поисковой выдачи. Нумерация страниц начинается с нуля */
    protected int $page = 0;

    /** Число позиций на странице выдачи, может принимать значения от 1 до 100 */
    protected int $perPage = 10;

    public function __construct(string $apiKey, int $searchId)
    {
        if ($apiKey === '' || $searchId === 0) {
            throw new \InvalidArgumentException('Не заданы ключ или идентификатор поиска');
        }

        $this->apiKey = $apiKey;
        $this->searchId = $searchId;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

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

    /** @inheritDoc */
    public function getResponse(): ResponseInterface
    {
        return new CatalogResponse();
    }

    /** @inheritDoc */
    public function getUrl(): string
    {
        if (!isset($this->text) || $this->text === '') {
            throw new \InvalidArgumentException('Не указан текст запроса');
        }

        $data = [
            'apikey' => $this->apiKey,
            'searchid' => $this->searchId,
            'text' => $this->text,
            'page' => $this->page,
            'per_page' => $this->perPage,
        ];

        return $this->baseUrl . '?' . http_build_query($data);
    }
}
