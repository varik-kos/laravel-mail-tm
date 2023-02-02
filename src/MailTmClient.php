<?php

namespace src;

use Exceptions\MailTmSendException;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class MailTmClient extends MailTmBase
{
    public function __construct(array $data = [])
    {
        parent::__construct();
        $this->data = $data;
    }

    public function register(array $params):  self
    {
        $this->data = $params;
        return $this;
    }

    /**
     * @throws MailTmSendException
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function send(): ?ResponseInterface
    {
        $params = $this->toArray();

        return $this->mailTm->sendRegister($params);
    }
}