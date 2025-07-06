<?php

namespace App\Helpers;

class Plural
{
    public static function getLithuanianPluralForm($count)
    {
        $count = abs($count); // Handle negative numbers
        $pluralForm = ($count % 10 == 0 || $count / 10 % 10 == 1) ? 0 : (($count % 10 == 1) ? 1 : 2);

        $translations = [
            0 => 'nuotraukų',
            1 => 'nuotrauka',
            2 => 'nuotraukos',
        ];

        return $translations[$pluralForm];
    }
}
