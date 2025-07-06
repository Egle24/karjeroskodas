<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CampRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $camp;
    public $registrationData;

    public function __construct($camp, $registrationData)
    {
        $this->camp = $camp;
        $this->registrationData = $registrationData;
    }

    private function getTranslations($key, $value)
    {
        $translations = [
            'payment' => [
                'manual' => 'Mokėsiu pats/pati',
                'school' => 'Mokės mano mokykla',
            ],
            'invoice' => [
                'pre_invoice' => 'Man reikės sąskaitos išankstiniam apmokėjimui',
                'no' => 'Man nereikės sąskaitos išankstiniam apmokėjimui',
                'post_invoice' => 'Man reikės sąskaitos-faktūros',
            ],
            'food_choice' => [
                'everything' => 'Valgau viską',
                'vegetarian_no_meat' => 'Esu vegetaras/-ė (nevalgau jokios mėsos)',
                'vegetarian_fish_only' => 'Esu vegetaras/-ė (valgau žuvį)',
                'vegan' => 'Esu veganas/-ė',
            ],
        ];

        return $translations[$key][$value] ?? $value;
    }

    public function build()
    {
        return $this->view('main.camp_registration')
            ->subject('Registracija į renginį ' . $this->camp->title)
            ->with([
                'camp' => $this->camp,
                'data' => array_merge($this->registrationData, [
                    'payment' => $this->getTranslations('payment', $this->registrationData['payment']),
                    'invoice' => $this->getTranslations('invoice', $this->registrationData['invoice']),
                    'food_choice' => $this->getTranslations('food_choice', $this->registrationData['food_choice']),
                ]),
            ]);
    }
}
