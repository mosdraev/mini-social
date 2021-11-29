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

    /**
     * Generates a post notification message
     *
     * @return void
     */
    private function generateAMessage()
    {
        $reference = $this->reference->content;
        $profile   = $this->notifier->profile;
        $this->message = "$profile->firstname $profile->lastname ";

        if ($this->type === self::LIKE_NOTIFICATION)
        {
            $this->message .= "liked your post, $reference";
        }

        if ($this->type === self::COMMENT_NOTIFICATION)
        {
            $this->message .= "commented your post, $reference";
        }
    }

    public function via($notifiable): array
    {
        return ['broadcast', 'database'];
    }

    /**
     * Broadcast notification to a websocket connection
     *
     * @param object $notifiable
     *
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'message' => substr($this->message, 0, 100) . '...'
        ]);
    }

    /**
     * Save notification to the database
     *
     * @param object $notifiable
     *
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => substr($this->message, 0, 100) . '...',
            'reference_id' => $this->reference->id
        ];
    }
}