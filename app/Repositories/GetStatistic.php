<?php

namespace App\Repositories;

use App\Bitfinexcoin;
use App\Exmocoin;
use Carbon\Carbon;

class GetStatistic
{
    /**
     * @param string $coin
     * @return bool
     */
    public function getCoin(string $coin, $hours)
    {
        if (null === $hours) {
            $date = Carbon::now()->subDay();
        } else {
//            $date = Carbon::now()->subMinutes($hours);
            $date = Carbon::now()->subHours($hours);
        }



        $exmo_coins = Exmocoin::select('min_price', 'max_price', 'created_at')
                    ->where([['created_at', '>', $date], 'coin'=>$coin])
                    ->get();

        $bitfinex_coins = Bitfinexcoin::select('min_price', 'max_price', 'created_at')
                    ->where([['created_at', '>', $date], 'coin'=>config('translate.exm-bitf.'.$coin)])
                    ->get();

        $dataPoints = [];

        $dataPoints['exmo'] = $exmo_coins->isNotEmpty() ? $this->getDataPoints($exmo_coins) : false;
        $dataPoints['bitfinex'] = $bitfinex_coins->isNotEmpty() ? $this->getDataPoints($bitfinex_coins) : false;

        return $dataPoints;
    }

    public function getExmo()
    {
        $url = 'https://api.exmo.com/v1/trades/?pair=BCH_USD,ETH_USD,XRP_USD,ETC_USD,ZEC_USD';

        try {
            $res = file_get_contents($url);
        } catch (\Exception $e) {
            \Log::info("EXMO-coin - error - " .$e->getMessage() .' - '. date("d-m-Y H:i:s"));
            $res = null;
        }

        if (!is_null($res)) {
            $res = json_decode($res, true);

            foreach ($res as $coin => $data) {

                if (is_array($data) && count($data) > 0) {
                    $price = array_column($data, 'price');
                    $date = date('Y-m-d H:i:s', max(array_column($data, 'date')));

                    $v['min_price'] = filter_var(min($price),
                        FILTER_SANITIZE_NUMBER_FLOAT, ['flags' => FILTER_FLAG_ALLOW_FRACTION]);
                    $v['max_price'] = filter_var(max($price),
                        FILTER_SANITIZE_NUMBER_FLOAT, ['flags' => FILTER_FLAG_ALLOW_FRACTION]);

                    $res = Exmocoin::updateOrCreate(['created_at' => $date, 'coin' => $coin], $v);

                    try {
                        $res->save();
                        \Log::info("EXMO-coin - $coin updated - " . date("d-m-Y H:i:s"));
                    } catch (Exception $e) {
                        \Log::info("EXMO-coin - $coin error - " .$e->getMessage() .' - '. date("d-m-Y H:i:s"));
                    }
                } else {
                    \Log::info("EXMO-coin - $coin no data - " . date("d-m-Y H:i:s"));
                }
            }
        }
        return true;
    }

    public function getBitfinex()
    {
        $coins = ['ethusd', 'xrpusd', 'etcusd', 'zecusd'];

        foreach ($coins as $coin) {

            try {
                $res = file_get_contents('https://api.bitfinex.com/v1/trades/' . strtoupper($coin));
            } catch (Exception $e) {
                \Log::info("Bitfinex-coin - error - " . $e->getMessage() . ' - ' . date("d-m-Y H:i:s"));
                $res = null;
            }


            if (null != $res) {
                $res = json_decode($res);
                $price = array_column($res, 'price');
                $date = date('Y-m-d H:i:s', max(array_column($res, 'timestamp')));

                $v['min_price'] = filter_var(min($price),
                    FILTER_SANITIZE_NUMBER_FLOAT, ['flags' => FILTER_FLAG_ALLOW_FRACTION]);
                $v['max_price'] = filter_var(max($price),
                    FILTER_SANITIZE_NUMBER_FLOAT, ['flags' => FILTER_FLAG_ALLOW_FRACTION]);

                $res = Bitfinexcoin::updateOrCreate(['created_at' => $date, 'coin' => $coin], $v);
            } else {
                \Log::info("Bitfinex-coin - $coin no data - " . date("d-m-Y H:i:s"));
                continue;
            }

            try {
                $res->save();
                \Log::info("Bitfinex-coin - $coin updated - " . date("d-m-Y H:i:s"));
            } catch (Exception $e) {
                \Log::info("Bitfinex-coin - $coin ERROR - " .$e->getMessage() .' - '. date("d-m-Y H:i:s"));
            }
        }
        return true;
    }

    public function getDataPoints(object $coins)
    {
        $dataPoints[0] = [];
        $dataPoints[1] = [];
        foreach($coins as $c){
            array_push($dataPoints[0], array("y"=> $c->min_price, "x"=> strtotime($c->created_at)*1000));
            array_push($dataPoints[1], array("y"=> $c->max_price, "x"=> strtotime($c->created_at)*1000));
        }

        $dataPoints['min'] = round(min(array_column($dataPoints[0], 'y')), 4);
        $dataPoints['max'] = round(max(array_column($dataPoints[1], 'y')), 4);


        $dataPoints[0] = json_encode($dataPoints[0], JSON_NUMERIC_CHECK);
        $dataPoints[1] = json_encode($dataPoints[1], JSON_NUMERIC_CHECK);

        return $dataPoints;
    }
}