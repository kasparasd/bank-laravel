<?php

namespace App\Services;

use Illuminate\Contracts\Foundation\Application;


class PersonalCodeService
{

    private $code;
    
    public $test = 'Labukas';

    public function __construct($code)
    {
        $this->code= $code;
    }

    public function validCode() : bool{
        $code = $this->code;
        
            // Tikriname, ar ivestas kodas yra skaiciai ir turi teisingą ilgi
            if (!is_numeric($code) || strlen($code) != 11) {
                return false;
            }
    
            // Isskiriame gimimo metus, menesi, diena
            $metai = substr($code, 1, 2);
            $menuo = substr($code, 3, 2);
            $diena = substr($code, 5, 2);
            // Tikriname gimimo datos validuma
            if (!checkdate($menuo, $diena, $metai)) {
                return false;
            }
    
            $suma = 0;
            for ($i = 0; $i < 10; $i++) {
                if ($i < 9) {
                    $suma += (int)$code[$i] * ((int)$i + 1);
                } else {
                    $suma += (int)$code[$i] * 1;
                }
            }
            // Tikriname paskutini skaiciu (kontrolini)
            $kontrolinisSk = substr($code, -1);
            // 33908118566
            // Skaičiuojame kontrolini skaiciu
            $liekana = $suma % 11;
            // Jei liekana lygi 10, tai paskutinis kontrolinis skaicius turi buti 0,
            // Jei liekana nelygi 10, tai liekana ir yra paskutinis kontrolinis skaicius
    
            $liekana = ($liekana == 10) ? 0 : $liekana;
    
            // Patikriname, ar kontrolinis skaicius atitinka liekana
            if ($liekana != $kontrolinisSk) {
                return false;
            }
    
            return true;
    }
}
