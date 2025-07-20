<?php

declare(strict_types=1);

namespace Ideal\YandexSearch;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Client
{
    protected HttpClientInterface $httpClient;

    private LoggerInterface $logger;

    private string $baseUrl;

    /** Ключ для доступа к поиску https://yandex.cloud/ru/docs/search-api/quickstart/ */
    protected string $apiKey;

    public function __construct(string $baseUrl, string $apiKey, LoggerInterface $logger)
    {
        $this->httpClient = $this->getHttpClient();
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
        $this->logger = $logger;
    }

    /**
     * Отправка запроса к Яндексу и получение ответа
     */
    public function send(RequestInterface $request): ResponseInterface
    {
        try {
            $response = $this->httpClient->request($request->getMethod(), $this->baseUrl . $request->getUrl(), [
                'headers' => [
                    'Authorization: Api-Key ' . $this->apiKey,
                    'Content-Type: application/json',
                ],
                'body' => $request->getJson(),
            ]);
        } catch (TransportExceptionInterface $e) {
            $this->logger->error('Ошибка при обращении к Yandex.Cloud', [
                'exception' => $e->getMessage(),
                'url' => $request->getUrl(),
                'body' => $request->getJson(),
            ]);

            return new XmlResponse();
        }

        try {
            $content = $response->getContent();
            $xmlStr = base64_decode($response->toArray()['rawData']);
            $xml = new \SimpleXMLElement($xmlStr);
        } catch (\Throwable $e) {
            $this->logger->error('Ошибка при распаковке ответа Yandex.Cloud', [
                'exception' => $e->getMessage(),
                'url' => $request->getUrl(),
                'body' => $content ?? 'Ответ недоступен.',
            ]);

            return new XmlResponse();
        }

        return (new XmlResponse())->setXml($xml);
    }

    private function getHttpClient(): HttpClientInterface
    {
        return HttpClient::create();
    }
}
