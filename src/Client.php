<?php

declare(strict_types=1);

namespace Ideal\YandexSearch;

class Client
{
    /**
     * Отправка запроса к Яндексу и получение ответа
     */
    public static function send(RequestInterface $request): ResponseInterface
    {
        $url = $request->getUrl();

        $content = file_get_contents($url);

        if ($content === false) {
            throw new \RuntimeException('Не удалось получить ответ от Яндекса');
        }

        return $request->getResponse()->setContent($content);
    }
}
