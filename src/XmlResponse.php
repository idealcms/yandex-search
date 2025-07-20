<?php

declare(strict_types=1);

namespace Ideal\YandexSearch;

class XmlResponse implements ResponseInterface
{
    /** @var array<Document>  */
    protected array $items = [];

    protected int $docsTotal;

    /** @inheritDoc */
    public function setXml(\SimpleXMLElement $xml): self
    {
        foreach ($xml->response->results->grouping->group as $group) {
            $url = (string) $group->doc->url;
            $passage = $group->doc->passages->passage;
            $this->items[$url] = new Document(
                strip_tags($group->doc->domain->asXML()),
                $url,
                strip_tags($group->doc->title->asXML(), ['hlword']),
                $passage === null ? null : strip_tags($passage->asXML(), ['hlword']),
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
