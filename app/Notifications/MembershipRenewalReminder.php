<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class MembershipRenewalReminder extends Notification
{

    public $user;
    public static $createUrlCallback;
    public static $toMailCallback;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->user);
        }

        return $this->buildMailMessage($this->renewUrl($notifiable));
    }

    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject('Priminimas pratęsti narystę')
            ->line('Norime jums priminti, kad jūsų narystė galioja iki ' . now()->endOfYear()->addMonth()->toDateString())
            ->action(Lang::get('Atnaujinti narystę'), $url)
            ->line('Jei narystės neatnaujinsite iki jos galiojimo pabaigos, jūsų paskyra bus pašalinta.');
    }

    protected function renewUrl($notifiable)
    {
        if (static::$createUrlCallback) {
            return call_user_func(static::$createUrlCallback, $notifiable, $this->user);
        }
        return url(route('profile.show'));
    }

    public static function createUrlUsing($callback)
    {
        static::$createUrlCallback = $callback;
    }

    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }

}
