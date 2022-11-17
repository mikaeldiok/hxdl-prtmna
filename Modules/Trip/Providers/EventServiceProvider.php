<?php

namespace Modules\Trip\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

//Events
Use Modules\Trip\Events\InspectionRegistered;

//Listeners
Use Modules\Trip\Listeners\NotifyInspection;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        InspectionRegistered::class => [
            NotifyInspection::class,
        ],
    ];
}
