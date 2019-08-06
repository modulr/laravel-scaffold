<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
//use Illuminate\Notifications\Messages\MailMessage;
//use Illuminate\Notifications\Messages\BroadcastMessage;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class DeactiveDealer extends Notification
{
    use Queueable;

    private $dealer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($dealer)
    {
        $this->dealer = $dealer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        //return ['database', 'mail', 'broadcast', TelegramChannel::class];
        return ['database', TelegramChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line($this->order['order'])
    //                 ->action('Ver Pedido', url($this->message['url']))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            $this->dealer
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    // public function toBroadcast($notifiable)
    // {
    //     return new BroadcastMessage([
    //         message => [
                //     'title' => 'Pedido nuevo '.$dealer->order,
                //     'url' => '/orders/availables',
                //     'userName' => $dealer->client->name,
                //     'userAvatarUrl' => $dealer->client->avatar_url,
                // ];
    //     ]);
    // }

    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to(env('TELEGRAM_BOT_TO', '-260576056')) // Optional.
            ->content("*¡Se desactivo ".$this->dealer->name."!*"); // Markdown supported.
            //->file($this->order->client->avatar_url, 'photo') // local photo
            //->button('Tomar Pedido', 'http://traeme.app/orders/availables'); // Inline Button
    }
}
