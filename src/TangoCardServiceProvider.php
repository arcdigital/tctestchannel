<?php

namespace NotificationChannels\TangoCard;

use Illuminate\Support\ServiceProvider;
use NotificationChannels\TangoCard\Exceptions\InvalidConfiguration;
use Unirest\Request;

class TangoCardServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(TangoCardChannel::class)
            ->needs(Request::class)
            ->give(function () {
                $config = config('services.tangocard');

                if (is_null($config)) {
                    throw InvalidConfiguration::configurationNotSet();
                }

                //$environmentConstant = strtoupper($config['environment']);
                //Configuration::$environment = Environments::GAMMA;



                return ;
            });
    }

}
