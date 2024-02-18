<?php

declare(strict_types=1);

namespace Ideal\YandexSearch;

class CatalogItem
{
    protected string $id;

    protected string $name;

    protected string $description;

    protected string $url;

    protected int $categoryId;

    /** @var array<int> */
    protected array $categoryParents;

    protected float $price;

    protected string $currencyId;

    protected string $vendor;

    protected string $snippet;

    protected  string $origSnippet;

    protected string  $mobileSnippet;

    protected bool $available;

    protected ?float $oldPrice;
}
