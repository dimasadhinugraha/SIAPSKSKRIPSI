<?php

namespace App\Notifications;

use App\Models\LetterRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLetterRequestNotification extends Notification
{
    use Queueable;

    protected $letterRequest;

    /**
     * Create a new notification instance.
     */
    public function __construct(LetterRequest $letterRequest)
    {
        $this->letterRequest = $letterRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'letter_request_id' => $this->letterRequest->id,
            'request_number' => $this->letterRequest->request_number,
            'letter_type' => $this->letterRequest->letterType->name,
            'requester_name' => $this->letterRequest->user->name,
            'message' => $this->letterRequest->user->name . ' mengajukan ' . $this->letterRequest->letterType->name,
            'url' => route('approvals.show', $this->letterRequest),
        ];
    }
}
