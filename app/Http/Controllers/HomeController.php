<?php

namespace App\Http\Controllers;

use App\Repositories\GetStatistic;
use App\Repositories\Translate;
use Illuminate\Http\Request;

require_once ('/home/jenshen/j2landing.com/oshaman/vendor/j7mbo/twitter-api-php/TwitterAPIExchange.php');

use TwitterAPIExchange;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//
//        $res = file_get_contents('https://api.bitfinex.com/v1/symbols');
//
//        dd($res);

//        $settings = array(
//            'oauth_access_token' => config('services.twitter.client_id'),
//            'oauth_access_token_secret' => config('services.twitter.client_secret'),
//            'consumer_key' => config('services.twitter.consumer_key'),
//            'consumer_secret' => config('services.twitter.consumer_secret')
//        );
//
//
//        $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
////        $getfield = '?user_id=339233390&count=2';
//        $getfield = '?screen_name=leprasorium&count=2';
//        $requestMethod = 'GET';
//
//        $twitter = new TwitterAPIExchange($settings);
//
//        $result = json_decode($twitter->setGetfield($getfield)
//            ->buildOauth($url, $requestMethod)
//            ->performRequest(), true);
//
//        dd($result);



        return view('home');
    }
}
