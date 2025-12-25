<?php

namespace App\Notifications;

use App\Models\LetterRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LetterApprovedNotification extends Notification
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
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Surat Anda Telah Disetujui - ' . $this->letterRequest->request_number)
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Surat Anda telah disetujui dan siap digunakan!')
            ->line('**Detail Surat:**')
            ->line('Nomor Surat: **' . $this->letterRequest->request_number . '**')
            ->line('Jenis Surat: **' . ($this->letterRequest->letterType ? $this->letterRequest->letterType->name : '-') . '**')
            ->line('Tanggal Disetujui: **' . $this->letterRequest->rw_processed_at->format('d F Y H:i') . '**')
            ->action('Lihat & Download Surat', route('letter-requests.show', $this->letterRequest->id))
            ->line('Anda dapat mengunduh surat dalam format PDF melalui dashboard Anda.')
            ->line('Terima kasih telah menggunakan layanan kami!');
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
            'letter_type' => $this->letterRequest->letterType ? $this->letterRequest->letterType->name : '-',
            'status' => 'approved',
            'message' => 'Surat Anda dengan nomor ' . $this->letterRequest->request_number . ' telah disetujui dan siap digunakan.',
            'url' => route('letter-requests.show', $this->letterRequest->id),
        ];
    }
}
