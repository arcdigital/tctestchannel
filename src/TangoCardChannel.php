<?php

namespace NotificationChannels\TangoCard;

use NotificationChannels\TangoCard\Exceptions\CouldNotSendNotification;
use Illuminate\Notifications\Notification;
use RaasLib\Exceptions\RaasClientException;
use RaasLib\Models\CreateOrderRequestModel;
use RaasLib\Models\NameEmailModel;
use RaasLib\RaasClient;


class TangoCardChannel
{
    /** @var RaasClient */
    protected $tangoCard;

    public function __construct(RaasClient $raasClient)
    {
        $this->tangoCard = $raasClient;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\TangoCard\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $routing = $notifiable->routeNotificationFor('TangoCard')) {
            return;
        }

        $message = $notification->toTangoCard($notifiable);

        $messageContent = $message->toArray();

        $orders = $this->tangoCard->getOrders();

        if ($recipient = $notifiable->routeNotificationFor('TangoCard')) {
            $recipientModel = new NameEmailModel($recipient['email'], $recipient['name'], null);
        } else {
            throw CouldNotSendNotification::invalidRecipient();
        }

        $orderModel = new CreateOrderRequestModel(
            'account1',
            $messageContent['amount'],
            'customer1',
            true,
            $messageContent['utid'],
            null,
            $messageContent['subject'],
            null,
            $messageContent['body'],
            $recipientModel,
            null,
            null
        );

        try {
            $orderResult = $orders->createOrder($orderModel);
        } catch (RaasClientException $exception) {
            var_dump($exception);
            throw CouldNotSendNotification::serviceRespondedWithAnError($exception->getMessage());
        }

    }
}
