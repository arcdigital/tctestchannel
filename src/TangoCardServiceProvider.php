<?php

namespace NotificationChannels\TangoCard;

use Illuminate\Support\ServiceProvider;
use NotificationChannels\TangoCard\Exceptions\InvalidConfiguration;

class TangoCardServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if (is_null(config('services.tangocard'))) {
            throw InvalidConfiguration::configurationNotSet();
        }

        /*$this->app->when(TangoCardChannel::class)
            ->needs(GuzzleClient::class)
            ->give(function () {
                $config = config('services.tangocard');

                if (is_null($config)) {
                    throw InvalidConfiguration::configurationNotSet();
                }

                if ($config['environment'] == 'production') {
                    $baseUri = 'https://api.tangocard.com/raas/v2/';
                } else {
                    $baseUri = 'https://integration-api.tangocard.com/raas/v2/';
                }

                return new GuzzleClient([
                    'base_uri' => $baseUri,
                    'auth' => [$config['platform_name'], $config['platform_key']],
                ]);
            });*/
    }

}
