<?php

namespace NotificationChannels\TangoCard\Events;

class TangoCardSent
{
    public $referenceOrderID, $externalRefID;

    public function __construct($referenceOrderID, $externalRefID)
    {
        $this->referenceOrderID = $referenceOrderID;
        $this->externalRefID = $externalRefID;
    }
}
