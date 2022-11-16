<?php

namespace Modules\Vehicle\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

//Events
Use Modules\Vehicle\Events\TankerRegistered;

//Listeners
Use Modules\Vehicle\Listeners\NotifyTanker;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        TankerRegistered::class => [
            NotifyTanker::class,
        ],
    ];
}
