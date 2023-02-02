<?php

namespace src;

use Illuminate\Support\ServiceProvider;

class MailTmServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $configPath = __DIR__ . '/../config/mailtm.php';

        $this->publishes([$configPath => config_path('mailtm.php')], 'mailtm');
    }

    public function register()
    {
        $this->app->bind(MailTm::class, static fn () =>  new MailTm(
            config('mailtm.token'),
            config('mailtm.id'),
            config('mailtm.api_host')
        ));
    }
}