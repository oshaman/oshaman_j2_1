<?php

namespace App\Http\Controllers;

use App\Repositories\GetStatistic;

class CoinController extends Controller
{
    public function show($coin, $hours=null)
    {
        $repo = new GetStatistic();
        $data = $repo->getCoin($coin, $hours);

        $title = strtoupper($coin);

        return view('statistic.show')->with(['title' => $title, 'dataPoints'=>$data, 'hours'=>$hours])->render();
    }

}
