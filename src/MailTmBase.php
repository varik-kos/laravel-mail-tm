<?php

namespace src;

use JsonSerializable;

class MailTmBase implements JsonSerializable
{
    protected array $data = [];

    public MailTm $mailTm;
    public function __construct()
    {
        $this->mailTm = app(MailTm::class);
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}