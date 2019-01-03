<?php

namespace App\Http\Controllers;

use App\Landing;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LandingController extends Controller
{
    protected $template = 'admin.index';
    protected $vars;
    protected $content;
    protected $title;

    public function show(Request $request)
    {

        /*if ($request->isMethod('post')) {

            $landing = Landing::find(31);
            $landing->title = $request->get('title');
            $landing->save();
            dd($landing);
        }
        $this->content = view('admin.services.test');

        $navigation = view('admin.navigation')->render();
        $this->vars = array_add($this->vars, 'navigation', $navigation);

        $header = view('admin.header')->render();
        $this->vars = array_add($this->vars, 'header', $header);

        $footer = view('admin.footer')->render();
        $this->vars = array_add($this->vars, 'footer', $footer);

        $this->vars = array_add($this->vars, 'content', $this->content);

        return view($this->template)->with($this->vars);*/


        $landings = Landing::all();

        $ratios = [];

        foreach($landings as $landing){

            $stop = Carbon::parse($landing->stop);
            $start = Carbon::parse($landing->start);

            $ratios[] = ceil($stop->diffInMinutes($start)/$landing->click);
        }

        return view('landing.show')->with(compact('landings', 'ratios'))->render();
    }

    public function blog(Request $request)
    {
        if ($request->isMethod('post')) {
            Landing::find(1)->increment('click');
        }


        $landing = Landing::find(1);
        $count_click = $landing->click;
        $client_ip = $request->ip();
        $proxy = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '';
        $port = $_SERVER['SERVER_PORT'] ?? '';

        \Log::info('Time - ' . date('d-m-Y H:i') . '  UserIp => ' . $client_ip . ' REMOTE_PORT => ' . $port . ' REMOTE_PROXY => ' . $proxy);
//        \Log::info('Time - '.date('d-m-Y H:i') .'  UserIp => '.$client_ip.' USER_AGENT => '.$request->header('User-Agent').' REMOTE_PORT => '.$request->header('X-Forwarded-For'));

        return view('landing.blog')->with(compact('client_ip', 'count_click'))->render();
    }

    public function strHandler($str)
    {
        $re = '/(\s[^\s]{1,3}|\s)$/mu';
//        $re = '/\s[^\s]{1,3}$/mu';

        preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);

        if (count($matches) > 0) {
            $str = preg_replace($re, '', $str);
            return $this->strHandler($str);
        } else {
            return $str;
        }

    }

    public function phones()
    {
        $str = '(0432) 57-27-77; (0522) 59-50-39;        (066) 520-80-66; (056) 788-71-71, (095) 270-50-71';

        $phones = explode('; ', preg_replace('/\s{2,}/', ' ', $str));


        $data = '';
        if (!empty($phones[0])) {
            foreach ($phones as $phone) {
                $data .= '<a href="tel:+38' . preg_replace('/[^\d]+/', '', $phone) . '"><img src="/assets/img/' . $this->getPic($phone) . '" alt="">' . $phone . '</a>';
            }
        }
        dd($phones, $str, $data);
    }

    public function getPic($phone)
    {
        preg_match('/\(([\d]+)\)/', $phone, $matches);
        if (!empty($matches[1])) {
            switch ($matches[1]) {
                case '050':
                    return 'vodafone-phone.png';
                case '066':
                    return 'vodafone-phone.png';
                case '0896':
                    return 'vodafone-phone.png';
                case '095':
                    return 'vodafone-phone.png';
                case '99':
                    return 'vodafone-phone.png';
                case '063':
                    return 'lifecell-phone.png';
                case '073':
                    return 'lifecell-phone.png';
                case '093':
                    return 'lifecell-phone.png';
                case '067':
                    return 'kievstar-phone.png';
                case '068':
                    return 'kievstar-phone.png';
                case '0897':
                    return 'kievstar-phone.png';
                case '096':
                    return 'kievstar-phone.png';
                case '097':
                    return 'kievstar-phone.png';
                case '098':
                    return 'kievstar-phone.png';
                default:
                    return 'city-phone.png';
            }
        }
        return 'city-phone.png';
    }
}
