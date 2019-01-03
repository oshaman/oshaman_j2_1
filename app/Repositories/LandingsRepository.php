<?php

namespace App\Repositories;

class LandingsRepository
{
    public function everyMinute()
    {
        $this->gets('1 min');

    }

    public function everyFiveMinutes()
    {
        $this->gets('5 min');
    }

    public function everyTenMinutes()
    {
        $this->gets('10 min');

    }

    public function everyFifteenMinutes()
    {
        $this->gets('15 min');

    }

    public function everyThirtyMinutes()
    {
        $this->gets('30 min');

    }

    public function hourly()
    {
        $this->gets('hourly');

    }

    public function daily()
    {
        $this->gets('daily');

    }

    public function gets($val)
    {
        $file = storage_path('app/public/landings.txt');
        $str = "время записи($val): " . date('d-m-Y H:i:s').PHP_EOL;
        file_put_contents($file, $str, FILE_APPEND | LOCK_EX);
    }
}