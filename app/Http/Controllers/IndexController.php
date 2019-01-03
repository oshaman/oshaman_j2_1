<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class IndexController extends Controller
{
    public function show()
    {
        /*$res = DB::table('user')->first();
        dd($res);*/


        $title = 'test Home Page!';
        return view('welcome')->with('title', $title)->render();
    }
    public function about()
    {
        /*$res = DB::table('user')->first();
        dd($res);*/


        $title = 'test';
        return view('welcome')->with('title', $title)->render();
    }
    public function policy()
    {
        /*$res = DB::table('user')->first();
        dd($res);*/


        $title = 'test';
        return view('welcome')->with('title', $title)->render();
    }
}
