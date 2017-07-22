<?php

namespace NotificationChannels\TangoCard;

use Illuminate\Support\ServiceProvider;
use NotificationChannels\TangoCard\Exceptions\InvalidConfiguration;
use RaasLib\RaasClient;
use RaasLib\Configuration;
use RaasLib\Environments;

class TangoCardServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(TangoCardChannel::class)
            ->needs(RaasClient::class)
            ->give(function () {
                $config = config('services.tangocard');

                if (is_null($config)) {
                    throw InvalidConfiguration::configurationNotSet();
                }

                //$environmentConstant = strtoupper($config['environment']);
                //Configuration::$environment = Environments::GAMMA;

                return new RaasClient(
                    $config['platform_name'],
                    $config['platform_key']
                );
                
            });
    }

}
