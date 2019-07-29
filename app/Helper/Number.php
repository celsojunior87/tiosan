<?php

namespace App\Helper;

class Number
{
    public static function formatCurrencyBr($money)
    {
        return self::moeda($money);
    }

    public static function getOnlyNumber($string)
    {
        $numero = preg_replace("/[^0-9]/", '', $string);
        return $numero;
    }

    public static function moeda($get_valor)
    {
        $source = array('.', ',');
        $replace = array('', '.');
        $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
        return str_replace('R$', '', $valor);
    }
}
