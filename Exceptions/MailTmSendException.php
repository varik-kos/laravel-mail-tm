<?php

namespace Exceptions;

use Exception;
use GuzzleHttp\Exception\ClientException;
use JsonException;

class MailTmSendException extends Exception
{
    public static function mailTmTokenIsEmpty(string $message): self
    {
        return new self($message);
    }

    /**
     * @param ClientException $exception
     * @return static
     * @throws JsonException
     */
    public static function mailTmResError(ClientException $exception): self
    {
        if (!$exception->hasResponse()) {
            return new self('MailTm responded with an error. Response body no found');
        }

        $statusCode = $exception->getResponse()->getStatusCode();
        $contents = $exception->getResponse()->getBody()->getContents();

        $result = json_decode($contents, false, 512, JSON_THROW_ON_ERROR);
        $description = $result->description ?? 'description not found';

        return new self('MailTm responded with an error ' . $statusCode . ' - ' . $description, 0, $exception);
    }
}