<?php

namespace App\Listeners;

use App\Events\ChangeStatusEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\WebhookServer\WebhookCall;

class ChangeEventHandler
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ChangeStatusEvent  $event
     * @return void
     */
    public function handle(ChangeStatusEvent $event)
    {
        WebhookCall::create()
           // ->url('https://webhook.site/cf88a3e8-1ad6-4f46-bb02-fb6de4bab81e')
            ->url('https://webhook.site/3a0042d5-d500-4202-bee7-7039d16b5bf3')
            ->doNotSign()
            ->doNotVerifySsl()
            ->payload(["order"=>$event->order_status])
            ->dispatch();
    }
}
