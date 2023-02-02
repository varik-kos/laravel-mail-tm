<?php

namespace src;

use Illuminate\Support\Facades\Facade;

class MailTmFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MailTm::class;
    }
}
