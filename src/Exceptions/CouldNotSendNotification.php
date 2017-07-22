<?php

namespace NotificationChannels\TangoCard\Exceptions;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError($response)
    {
        return new static('Tango Card responded with an error: `'.$response.'`');
    }

    public static function invalidRecipient()
    {
        return new static('Invalid recipient provided.');
    }
}
