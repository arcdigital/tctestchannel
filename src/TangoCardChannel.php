<?php

namespace NotificationChannels\TangoCard;

use NotificationChannels\TangoCard\Exceptions\CouldNotSendNotification;
use Illuminate\Notifications\Notification;

class TangoCardChannel
{
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

        $order = [
            'accountIdentifier' => config('services.tangocard.account'),
            'customerIdentifier' => config('services.tangocard.customer'),
            'sendEmail' => true,
            'amount' => $messageContent['amount'],
            'utid' => $messageContent['utid'],
            'subject' => $messageContent['subject'],
            'body' => $messageContent['body'],
        ];

        if ($recipient = $notifiable->routeNotificationFor('TangoCard')) {
            $order['recipient'] = ['email' => $recipient['email'], 'firstName' => $recipient['name']];
        } else {
            throw CouldNotSendNotification::invalidRecipient();
        }

        $body = \Unirest\Request\Body::json($order);
        \Unirest\Request::auth(config('services.tangocard.platform_name'), config('services.tangocard.platform_key'));

        $headers = array('Accept' => 'application/json', 'Content-Type' => 'application/json');

        $response = \Unirest\Request::post('https://integration-api.tangocard.com/raas/v2/orders', $headers, $body);
    }
}
