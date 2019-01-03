<?php

namespace App\Http\Controllers;

use App\Classification;
use Illuminate\Http\Request;

class ClassificationController extends Controller
{
    public function index()
    {
        $model = new Classification();

        dd($model->where(['class_alias' => 'C'])->get());
    }
}
