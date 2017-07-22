<?php

namespace NotificationChannels\TangoCard\Exceptions;

class InvalidConfiguration extends \Exception
{
    public static function configurationNotSet()
    {
        return new static('In order to send notification via Tango Card you need to add credentials in the `tangocard` key of `config.services`.');
    }
}
