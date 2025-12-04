<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountActivated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
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
            ->subject('Akun Anda Telah Diaktifkan')
            ->greeting('Halo ' . ($notifiable->name ?? '') . ',')
            ->line('Akun Anda telah disetujui dan diaktifkan oleh admin. Anda sekarang dapat masuk menggunakan kredensial Anda.')
            ->action('Masuk', url('/login'))
            ->line('Jika ada kendala, balas email ini atau hubungi kami di admin@domain.com.')
            ->salutation('Hormat kami,' . PHP_EOL . 'Tim SIAPSK');
    }
}
