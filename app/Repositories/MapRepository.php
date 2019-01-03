<?php
/**
 * Created by PhpStorm.
 * User: ххх
 * Date: 21.02.2018
 * Time: 16:43
 */

namespace App\Repositories;

use App\Delivery;
use App\Dispensary;
use App\Doctor;
use App\Repositories\lib\curl;
use App\Repositories\lib\curl_cars;
use App\Repositories\lib\curl2;
use File;
use DB;
include_once('lib/simple_html_dom.php');

class MapRepository
{
    public function handle($request)
    {
        /*if ('text/xml' !== $request->file('file')->getMimeType()) {
            dd('error-mime');
        }*/

        /*ini_set('memory_limit', '256M');
        ini_set('max_execution_time', 600);*/

        $re = '/(http(s)?:\/\/[^\/]+)(.*)/';
        preg_match_all($re, $request->get('url'), $matches, PREG_SET_ORDER, 0);


        $host = $matches[0][1];

        $file = simplexml_load_file($request->get('url'), 'SimpleXMLElement');

        $c = curl::app($host)
            ->config_load('/home/jenshen/j2landing.com/oshaman/app/Repositories/lib/wiki.cnf')
            ->follow(true);

        $nums = count($file);

        if (0 == $nums) {
            return ['error' => 'No data'];
        }

        $skip = $request->get('skip');

        if ($skip >= $nums) {
            return ['error' => 'Готово'];
        }

        $result = [];


        $count = 0;
        $take = 1;
        foreach ($file as $link) {
            $count++;
            if ($count <= $skip) continue;
            if ($take > 50) continue;
            $uri = str_replace($host . '/', '', $link->loc);
            if ($host == $uri) continue;
            $header = $c->request('/' . $uri);

            switch ($header) {
                case 200:  # OK
//                    $result['urls'][] = [$header, $link->loc];
                    break;
                default:
                    $result['urls'][] = [$header, $link->loc];
            }
            $take++;
        }
        $result['nums'] = $nums;

        return $result;
    }

    public function getGreen2($request)
    {


//        $req = file_get_contents('https://api-g.weedmaps.com/wm/web/v1/listings/markham/menu?type=dispensary');
        /*$req = file_get_contents('https://api-g.weedmaps.com/wm/web/v1/listings/price-is-right-ftp-3-5g-25-or-7g-50/menu?type=dispensary');
        dd(json_decode($req));*/

        /* $fileName = time() . '_datafile.json';
         File::put(public_path('/uploads/'.$fileName),$req);

         dd(json_decode($req));
         $cats = json_decode($req)->categories;

         foreach ($cats[6]->items as $item) {
             dd($item);
         }*/

//        $uri = '/dispensaries/price-is-right-ftp-3-5g-25-or-7g-50';
        /*$uri = '/deliveries/budex-4';
        $c = curl2::app('https://weedmaps.com')
            ->config_load('/home/jenshen/j2landing.com/oshaman/app/Repositories/lib/wiki-green.cnf')
            ->follow(true);

        $header = $c->request($uri);

//dd($header);
echo $header['html'];die;*/


        $file = simplexml_load_file(public_path('dispensaries.xml'), 'SimpleXMLElement', LIBXML_NOBLANKS);
//        $file = simplexml_load_file(public_path('listings.xml'), 'SimpleXMLElement', LIBXML_NOBLANKS);
//        dd($file);
        $count = 0;
//        $businesses = [];
//        $re = '#https:\/\/weedmaps\.com\/([^\/]+)\/in\/(?:[^\/]+\/)+([^\/]+)#';
        foreach ($file as $item) {
            $count++;
//            if (5 > $count) continue;
//            if (100 < $count) continue;
            $str = preg_replace('https://weedmaps.com/dispensaries/', '', $item->loc);

            if (0 == strlen($str)) continue;

            /* dd($item);
             $str = preg_replace('#[\n\s]+#', '', $item->loc->__toString());

             preg_match($re, $str, $matches);
             if (0 == count($matches)) {
                 continue;
             }
 //            dd($matches);
             $business = $matches[1] ?? null;
             $title = $matches[2] ?? null;

             if (null === $title || null === $business) continue;
             $businesses[$business][$title] = $this->getJquery($title, $business);*/

            echo $count . ' - - ' . $item->loc . '<br>';
        }
        dd($businesses);
        return $file;
    }

    public function getGreen($request)
    {
        $c = curl2::app('https://countrycode.org/')
            ->config_load('/home/jenshen/j2landing.com/oshaman/app/Repositories/lib/wiki-green.cnf')
            ->follow(true);

        $req = $c->request('/');

        $html = str_get_html($req['html']);
        $table = $html->find('div.visible-lg table.main-table');


        $res = [];
        foreach($table[0]->last_child()->find('tr') as $tr){

            $res[$tr->childNodes(0)->plaintext] = [
                'href' => $tr->childNodes(0)->first_child()->href,
                'country code' => $tr->childNodes(1)->plaintext,
                'iso codes' => $tr->childNodes(2)->plaintext,
            ];
        }

        return $res;
    }
//    public function getGreen($request)
//    {
//        $str = 'medical-marijuana-treatment-clinics-of-florida-dff7af64-4850-44df-ad2a-eb6edf74f4c4';
//        $content = file_get_contents("https://api-g.weedmaps.com/wm/web/v1/listings/$str/menu?type=doctor");
//
//        Doctor::create(['content' => $content]);
//
//
//        dd(DB::table('doctors')->count());
//        dd(json_decode(Doctor::find(158)->content));
//
//
//        $file = simplexml_load_file(public_path('dispensaries.xml'), 'SimpleXMLElement', LIBXML_NOBLANKS);
//
//        $count = 0;
//        foreach ($file as $item) {
//            $count++;
//            if (1 == $count) continue;
////            if (15 > $count) continue;
//            if (100 < $count) continue;
//            $str = preg_replace('#https://weedmaps.com/dispensaries/#', '', $item->loc);
//
//            $content = $this->getJson($str);
//
//            Dispensary::create(['content' => $content]);
//
//        }
//        dd($count);
//    }

    public function getJson($title)
    {


        $c = curl2::app('https://api-g.weedmaps.com')
            ->config_load('/home/jenshen/j2landing.com/oshaman/app/Repositories/lib/wiki-green.cnf')
            ->follow(true);

        $uri = "/wm/web/v1/listings/$title/menu?type=dispensary";
        $req = $c->request($uri);
//        dd($req['html']);
        /*try {
            $req = file_get_contents("https://api-g.weedmaps.com/wm/web/v1/listings/$title/menu?type=dispensary");
        } catch (\Exception $e) {
            $req = null;
            \Log::info('Error - ' . $e->getMessage());
        }*/

        return $req['html'];
    }

    public function getCars($request)
    {

        $cookies = 'cookie.txt';

        $host = 'https://www.copart.com';

        $c = curl_cars::app($host)
            ->config_load('/home/jenshen/j2landing.com/oshaman/app/Repositories/lib/wiki.cnf')
            ->cookie($cookies)
            ->follow(true);


        $this->getValidCookie($c);

        $uri = '/public/data/lotdetails/solr/29404756';
//        $uri = '/public/data/lotdetails/solr/23404748';


        $req = $c->request($uri);

        $data = json_decode($req['html']);

        echo '<pre>';
        var_dump($data->data->lotDetails->ess);
//        var_dump($data->data->lotDetails);
        echo '</pre>';
        die();

    }

    public function getValidCookie($c)
    {
        $req = $c->request('/');

        if (strpos($req['html'], 'Request unsuccessful. Incapsula incident ID')) {
            $file = preg_split('#\\n#', file_get_contents(public_path('cookie.txt')));
            $id = preg_split('#\\t#', $file[4]);
            $req = $c->request('/public/data/userConfig?_=' . $id[4]);
        }

        $re = '/var b=\"([^\"]+)"/';

        if (preg_match($re, $req['html'], $str)) {
            $z = "";
            for ($i = 0; $i < strlen($str[1]); $i += 2) {

                $z = $z . chr(intval(substr($str[1], $i, 2), 16));
            }

            $re = '/SWHANEDL=([^\"]+)"/';
            preg_match($re, $z, $res);

            $uri = '/_Incapsula_Resource?SWHANEDL=' . $res[1];
            $c->request($uri);
        }
        return true;
    }
}