<?php

declare(strict_types=1);

namespace Ideal\YandexSearch;

class CatalogResponse implements ResponseInterface
{
    protected array $items;

    protected int $docsTotal;

    /** @inheritDoc */
    public function setContent(string $content): self
    {
        try {
            $response = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new \RuntimeException('Не могу декодировать ответ Яндекса: ' . $content, $e);
        }

        $this->items = $response->documents ?? [];
        $this->docsTotal = $response->docsTotal;

        return $this;
    }

    /**
     * Получение только списка идентификаторов найденных товаров
     */
    public function getIds(): array
    {
        $ids = [];
        foreach ($this->items as $item) {
            $ids[] = $item->id;
        }

        return $ids;
    }

    /** @inheritDoc */
    public function getDocuments(): array
    {
        return $this->items;
    }

    /** @inheritDoc */
    public function getDocsTotal(): int
    {
        return $this->docsTotal;
    }
}
