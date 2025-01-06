<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendVerificationOtp extends Notification
{
    use Queueable;

    protected $otp;

    /**
     * Create a new notification instance.
     */
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Xác thực tài khoản')
            ->greeting('Xin chào!')
            ->line('Cảm ơn bạn đã đăng ký. Đây là mã xác thực tài khoản của bạn:')
            ->line('**' . $this->otp . '**') // Hiển thị OTP
            ->line('Lưu ý: Mã xác thực sẽ hết hạn sau 60 phút.')
            ->line('Nếu không phải bạn thực hiện, vui lòng bỏ qua email này.')
            ->line('')
            ->salutation('Trân trọng, MOVIE PRO');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
