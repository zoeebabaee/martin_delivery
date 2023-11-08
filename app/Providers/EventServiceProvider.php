<?php

namespace App\Providers;

use App\Events\ChangeStatusEvent;
use App\Events\FinalWebhookCallFailedEvent;
use App\Events\WebhookCallSucceededEvent;
use App\Listeners\ChangeEventHandler;
use App\Listeners\FinalWebhookCallSucceededEventHandler;
use App\Listeners\WebhookCallSucceededEventHandler;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        ChangeStatusEvent::class => [
            ChangeEventHandler::class,
        ],
        WebhookCallSucceededEvent::class => [
            WebhookCallSucceededEventHandler::class,
        ],
        FinalWebhookCallFailedEvent::class => [
            FinalWebhookCallSucceededEventHandler::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
