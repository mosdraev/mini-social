<?php

namespace App\Notifications;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class PostNotification extends Notification implements ShouldBroadcast
{
    const LIKE_NOTIFICATION = 'like_notification';
    const COMMENT_NOTIFICATION = 'comment_notification';

    public $notifier;
    public $reference;
    public $type;

    private $message;

    public function __construct($type, $notifier, $reference)
    {
        $this->notifier = $notifier;
        $this->reference = $reference;
        $this->type = $type;

        $this->generateAMessage();
    }

    private function generateAMessage()
    {
        $reference = $this->reference->content;

        if ($this->type === self::LIKE_NOTIFICATION)
        {
            $this->message = "liked your post, $reference";
        }

        if ($this->type === self::COMMENT_NOTIFICATION)
        {
            $this->message = "commented your post, $reference";
        }
    }

    public function via($notifiable): array
    {
        return ['broadcast'];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        $profile  = $this->notifier->profile;
        $fullname = "$profile->firstname $profile->lastname";
        $message  = "$fullname $this->message";

        return new BroadcastMessage([
            'message' => substr($message, 0, 100) . '...'
        ]);
    }
}