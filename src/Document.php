<?php

declare(strict_types=1);

namespace Ideal\YandexSearch;

class Document
{
    public string $domain;

    public string $url;

    public string $title;

    public array $passages;

    public function __construct(
        string $domain,
        string $url,
        string $title,
        array $passages
    ) {
        $this->domain = $domain;
        $this->url = $url;
        $this->title = $title;
        $this->passages = $passages;
    }
}