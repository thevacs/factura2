<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;
use NotificationChannels\Telegram\TelegramFile;
use Illuminate\Support\Facades\Http;

class ProfitVC2 extends Notification
{
    use Queueable;

    private $betsan = "-1001212976308";
    private $vc = "-1001413639372";
    private $endpoitnTenorAPI = "https://api.tenor.com/v1/search?q=profit&key=BLITMT0XM0QH&limit=8";
    private $mensaje;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($mensaje)
    {
        $this->mensaje = $mensaje;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toTelegram($notifiable)
    {
        $git = false;
        if ($git) {

            return TelegramFile::create()
                            ->to($this->betsan)
                            ->content($this->mensaje)
                            ->animation($git); 
        } else {
            return TelegramMessage::create()
                ->to($this->betsan)
                ->content($this->mensaje);
        }
    }

    private function git()
    {
        $response = Http::get($this->endpoitnTenorAPI);

        if ($response->successful()) {
            $respuesta = $response->json();
            $numero = rand(0, (count($respuesta['results']) - 1));
            $git = $respuesta['results'][$numero]['media'][0]['tinygif']['url'];
            return $git;
        } else {
            return false;
        }
    }

}