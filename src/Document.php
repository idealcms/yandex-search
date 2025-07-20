<?php

declare(strict_types=1);

namespace Ideal\YandexSearch;

class Document
{
    public string $domain;

    public string $url;

    public string $title;

    public ?string $passage = null;

    public function __construct(
        string $domain,
        string $url,
        string $title,
        ?string $passage
    ) {
        $this->domain = $domain;
        $this->url = $url;
        $this->title = $title;
        $this->passage = $passage;
    }
}