<?php

namespace NotificationChannels\TangoCard;

use GuzzleHttp\Client as GuzzleClient;
use NotificationChannels\TangoCard\Events\TangoCardSent;
use NotificationChannels\TangoCard\Exceptions\CouldNotSendNotification;
use Illuminate\Notifications\Notification;

class TangoCardChannel
{
    public $responseData;

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
            'externalRefID' => $messageContent['externalRefID'],
        ];

        if ($recipient = $notifiable->routeNotificationFor('TangoCard')) {
            $order['recipient'] = ['email' => $recipient['email'], 'firstName' => $recipient['firstName'], 'lastName' => $recipient['lastName']];
        } else {
            throw CouldNotSendNotification::invalidRecipient();
        }

        $config = config('services.tangocard');

        if ($config['environment'] == 'production') {
            $baseUri = 'https://api.tangocard.com/raas/v2/';
        } else {
            $baseUri = 'https://integration-api.tangocard.com/raas/v2/';
        }

        $client = new GuzzleClient([
            'base_uri' => $baseUri,
            'auth' => [$config['platform_name'], $config['platform_key']],
        ]);

        $response = $client->post('orders', [
            'json' => $order
        ]);

        if ($response->getStatusCode() != 201) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($response->getBody());
        }

        $responseBody = json_decode($response->getBody());

        event(new TangoCardSent($responseBody->referenceOrderID, $responseBody->externalRefID));

    }
}
