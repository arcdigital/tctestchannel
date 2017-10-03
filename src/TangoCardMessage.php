<?php

namespace NotificationChannels\TangoCard;

class TangoCardMessage
{
    /** @var float */
    protected $amount;

    /** @var string */
    protected $utid;

    /** @var string */
    protected $externalRefID;

    /** @var string */
    protected $subject = null;

    /** @var string */
    protected $body = null;

    /**
     * @param float $amount
     * @param string $utid
     * @param string $externalRefID
     *
     * @return static
     */
    public static function create($amount, $utid = 'U561593', $externalRefID = null)
    {
        return new static($amount, $utid, $externalRefID);
    }

    /**
     * @param float $amount
     * @param string $utid
     * @param string $externalRefID
     */
    public function __construct($amount, $utid = 'U561593', $externalRefID = null)
    {
        $this->amount = $amount;
        $this->utid = $utid;
        $this->externalRefID = $externalRefID;
    }

    /**
     * Set the amount.
     *
     * @param float $value
     *
     * @return $this
     */
    public function amount($value)
    {
        $this->amount = $value;

        return $this;
    }

    /**
     * Set the utid.
     *
     * @param string $value
     *
     * @return $this
     */
    public function utid($value)
    {
        $this->utid = $value;

        return $this;
    }

    /**
     * Set the externalRefID.
     *
     * @param string $value
     *
     * @return $this
     */
    public function externalRefID($value)
    {
        $this->externalRefID = $value;

        return $this;
    }

    /**
     * Set the message subject.
     *
     * @param string $value
     *
     * @return $this
     */
    public function subject($value)
    {
        $this->subject = $value;

        return $this;
    }

    /**
     * Set the message body.
     *
     * @param string $value
     *
     * @return $this
     */
    public function body($value)
    {
        $this->body = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $message = [
            'amount' => $this->amount,
            'utid' => $this->utid,
            'externalRefID' => $this->externalRefID,
            'subject' => $this->subject,
            'body' => $this->body,
        ];

        return $message;
    }
}
