<?php

namespace App\Http\Controllers;

use App\Repositories\MapRepository;
use App\Service;
use Illuminate\Http\Request;
use Validator;

class GreenController extends Controller
{
    public function index(Request $request)
    {
        $repository = new MapRepository();

        $result = $repository->getGreen($request);
        dd($result);

//        =============================================

        $str = '
            Купить стиральные машины Candy (Цвет - Белый) в интернет-магазине бытовой техники 
            590.ua. :phone:(050) 590-0-590. Стиральные машины candy, candy (Цвет - Белый) : 
            бесплатная доставка по Киеву и всей стране.Лучшие цены на стиральные машины Цвет - 
            Белый в интернет магазине 590.ua. Качественные стиральные машины Цвет - Белый по доступным ценам.
             Мы осуществляем доставку товара стиральные машины Белый по всей Украине.
        ';

        $pattern = '#\s[^\s]+\.{3}#';
        $asasas = preg_replace($pattern, ' ...Далі', str_limit($str, 64));
        dd($asasas);
//	$pattern = '(?<=\d)(?=(\d{3})+(?=$|\s))';
//	$pattern = '(?<=\d)(?=(\d{3})+(?!\d))';
//================================
        $pattern = '/.+\[\d\]\[(\d)/';
        $str = 'City[1][1]';
        $replacement = '2';

        $asasas = preg_replace($pattern, $replacement, $str);

        dd($asasas);
//========================

        $months = array(
            1 => 'января',
            2 => 'февраля',
            3 => 'марта',
            4 => 'апреля',
            5 => 'мая',
            6 => 'июня',
            7 => 'июля',
            8 => 'августа',
            9 => 'сентября',
            10 => 'октября',
            11 => 'ноября',
            12 => 'декабря');


        $day = date("d", strtotime('2017-02-23'));
        $year = date("Y", strtotime('2017-02-23'));
        $month = $months[date("n", strtotime('2017-02-23'))];


        echo $day . ' ' . $month . ' ' . $year;
        /*if ($request->isMethod('post')) {
            $repository = new MapRepository();

            $result=$repository->getGreen($request);
            dd($result);
        }*/

        $model = Service::where('id', 4)->first();
        $model->approved = 1;
//        dd($model);
        return view('green.show')->with(['model' => $model]);
    }

    public function testPgn(Request $request)
    {

        $repository = new MapRepository();
//dd('sssssss');
        $result = $repository->getCars($request);
//        dd($result);

dd($result);
//        dd($request->all());

//        $articles = Service::where([['id', '>', 5]])->skip(5)->paginate(10);

        return view('green.cars')->with(compact('result'))->render();
    }
}
