<?php

declare(strict_types=1);

namespace Ideal\YandexSearch;

class XmlResponse implements ResponseInterface
{
    /** @var array<Document> */
    protected array $items = [];

    protected int $docsTotal = 0;

    /** @inheritDoc */
    public function setXml(\SimpleXMLElement $xml): self
    {
        if (empty($xml->response->results->grouping)) {
            return $this;
        }

        foreach ($xml->response->results->grouping->group as $group) {
            $url = (string) $group->doc->url;
            $passages = [];
            foreach ($group->doc->passages as $passage) {
                $passages[] = strip_tags((string) $passage->asXML(), ['hlword']);
            }
            $this->items[$url] = new Document(
                strip_tags((string) $group->doc->domain->asXML()),
                $url,
                strip_tags((string) $group->doc->title->asXML(), ['hlword']),
                $passages,
            );
        }

        // 0 - phrase, 1 - strict, 2 - all
        $this->docsTotal = (int) strip_tags($xml->response->found[0]->asXml());

        return $this;
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
