<?php

namespace NotificationChannels\TangoCard;

class TangoCardMessage
{
    /** @var float */
    protected $amount;

    /** @var string */
    protected $utid;

    /** @var string */
    protected $subject = null;

    /** @var string */
    protected $body = null;

    /**
     * @param float $amount
     * @param string $utid
     *
     * @return static
     */
    public static function create($amount, $utid = 'U561593')
    {
        return new static($amount, $utid);
    }

    /**
     * @param float $amount
     * @param string $utid
     */
    public function __construct($amount, $utid = 'U561593')
    {
        $this->amount = $amount;
        $this->utid = $utid;
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
            'subject' => $this->subject,
            'body' => $this->body,
        ];

        return $message;
    }
}
