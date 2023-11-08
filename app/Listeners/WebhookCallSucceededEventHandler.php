<?php

namespace App\Listeners;

use App\Events\WebhookCallSucceededEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class WebhookCallSucceededEventHandler
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
     * @param  \App\Events\WebhookCallSucceededEvent  $event
     * @return void
     */
    public function handle(WebhookCallSucceededEvent $event)
    {
        //
    }
}
