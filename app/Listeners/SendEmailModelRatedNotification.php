<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\ModelRated;
use App\Notifications\ModelRatedNotification;

class SendEmailModelRatedNotification
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ModelRated $event)
    {
        $rateable = $event->getRateable();

        if ($rateable instanceof Product) {

            $notification = new ModelRatedNotification(
                $event->getQualifier()->name,
                $rateable->name,
                $event->getScore()
            );

            $rateable->createdBy->notify($notification);
        }
    }
}
