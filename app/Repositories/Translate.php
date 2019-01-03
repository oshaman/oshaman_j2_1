<?php
namespace App\Repositories;

class Translate
{
    static function ruEn(string $str)
    {
        $str = mb_strtolower($str, 'UTF-8');

        $leter_array = config('translate.en-ru');

        foreach ($leter_array as $kyr => $leter) {
            $str = str_replace($leter, $kyr, $str);
        }
        dd($str);
        //  A-Za-z0-9-
//        $str = preg_replace('/(\s|[^A-Za-z0-9\-_])+/', '-', $str);

        $str = trim($str);

        return $str;
    }
}