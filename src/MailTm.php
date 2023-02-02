<?php

namespace src;

use Enums\MimeTypeEnum;
use Enums\RequestEnum;
use Exception;
use Exceptions\MailTmSendException;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Psr\Http\Message\ResponseInterface;

class MailTm
{
    protected HttpClient $httpClient;

    protected ?string $token;
    protected ?string $id;
    protected string $apiBaseUri;
    public function __construct(string $token = null, string $id = null, string $apiBaseUri = null)
    {
        $this->httpClient = new HttpClient([
            'headers' => [
                'accept'        => MimeTypeEnum::M_TYPE_JSON->value,
                'authorization' => 'Bearer ' . $token
            ]
        ]);
        $this->token = $token;
        $this->id = $id;
        $this->setApiBaseUri($apiBaseUri);
    }

    /**
     * @throws MailTmSendException
     * @throws GuzzleException
     * @throws JsonException
     */
    public function sendRegister(array $params): ?ResponseInterface
    {
        return $this->sendRequest(RequestEnum::METHOD_POST->value, $params);
    }

    public function setApiBaseUri(string $apiBaseUri): self
    {
        $this->apiBaseUri = rtrim($apiBaseUri, '/');

        return $this;
    }

    protected function httpClient(): HttpClient
    {
        return $this->httpClient;
    }

    /**
     * @throws MailTmSendException|JsonException|GuzzleException
     */
    protected function sendRequest(string $method = 'GET', array $params = []): ?ResponseInterface
    {
        if (blank($this->token)) {
            throw MailTmSendException::mailTmTokenIsEmpty('You must provide your MailTm token to make  API requests.');
        }

        if (in_array($method, [RequestEnum::METHOD_POST->value, RequestEnum::METHOD_PATCH->value])) {
            $params = json_encode($params);
        }

        try {
            return $this->httpClient()->request($method, $this->apiBaseUri, $params);
        } catch (ClientException $e) {
            throw MailTmSendException::mailTmResError($e);
        } catch (Exception $e) {
            throw MailTmSendException::mailTmTokenIsEmpty($e);
        }
    }
}