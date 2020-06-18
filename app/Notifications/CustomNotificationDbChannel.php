<?php

namespace App\Notifications;



use Illuminate\Notifications\Notification;

class CustomNotificationDbChannel
{
    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toDatabase($notifiable);

        return $notifiable->routeNotificationFor('database')->create([
            'id' => $notification->id,
            'identifier' => $data['identifier'],
            'type' => get_class($notification),
            'data' => $data,
            'read_at' => null,
        ]);
    }



}

