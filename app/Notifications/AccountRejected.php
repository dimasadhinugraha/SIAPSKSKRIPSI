<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountRejected extends Notification
{
    use Queueable;

    public $reason;

    /**
     * Create a new notification instance.
     */
    public function __construct($reason)
    {
        $this->reason = $reason;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Pendaftaran Akun Ditolak')
            ->greeting('Halo ' . ($notifiable->name ?? '') . ',')
            ->line('Maaf, pendaftaran akun Anda telah ditolak oleh admin.')
            ->line('**Alasan Penolakan:**')
            ->line($this->reason)
            ->line('Jika Anda merasa ini adalah kesalahan atau ingin mengajukan pendaftaran ulang dengan data yang benar, silakan hubungi kami atau daftar kembali dengan data yang valid.')
            ->action('Daftar Ulang', url('/register'))
            ->line('Jika ada pertanyaan, balas email ini atau hubungi kami di admin@domain.com.')
            ->salutation('Hormat kami,' . PHP_EOL . 'Tim SIAPSK');
    }
}
