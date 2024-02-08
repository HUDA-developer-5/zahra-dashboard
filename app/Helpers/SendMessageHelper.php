<?php

namespace App\Helpers;

use App\Enums\MessageSubscriptionTypesEnums;
use App\Services\Admin\MessageSubscription\MessageValidationService;
use App\Services\Global\Twilio\TwilioService;

class SendMessageHelper
{
    /**
     * @throws \Exception
     */
    public function sendMessage($number, $message, MessageSubscriptionTypesEnums $messageSubscriptionTypesEnums): bool
    {
        // validate the message subscription
        if (!(new MessageValidationService())->validate($messageSubscriptionTypesEnums)) {
            return false;
        }

        // send message
        if (in_array($messageSubscriptionTypesEnums->value, [MessageSubscriptionTypesEnums::WHATSAPP->value, MessageSubscriptionTypesEnums::SMS->value])) {
            return (new TwilioService())->sendMessage($number, $message, $messageSubscriptionTypesEnums);
        }
        return false;
    }
}
