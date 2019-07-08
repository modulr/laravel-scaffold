<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
//use Illuminate\Notifications\Messages\MailMessage;
//use Illuminate\Notifications\Messages\BroadcastMessage;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TakeOrder extends Notification
{
    use Queueable;

    private $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
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
            $this->order
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
                //     'title' => 'Pedido nuevo '.$order->order,
                //     'url' => '/orders/availables',
                //     'userName' => $order->client->name,
                //     'userAvatarUrl' => $order->client->avatar_url,
                // ];
    //     ]);
    // }

    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to(env('TELEGRAM_BOT_TO', '-260576056')) // Optional.
            ->content("*¡Mandado Tomado!* 🖐 \n Mandado: ".$this->order->order." \n Dirección: ".$this->order->address." \n Envio: ".$this->order->delivery_costs." \n Cliente: ".$this->order->client->name. ', Tel: '.$this->order->client->cellphone. " \n Repartidor: " .$this->order->dealer->name);
    }
}
