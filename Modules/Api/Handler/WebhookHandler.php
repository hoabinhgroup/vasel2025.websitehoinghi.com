<?php
namespace Module\Api\Handler;

use Spatie\WebhookClient\ProcessWebhookJob;

class WebhookHandler extends ProcessWebhookJob
{
    public function handle()
    {
        logger('I was here');
        logger($this->webhookCall);
    }
}
