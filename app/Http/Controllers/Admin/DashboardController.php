<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    protected $template = 'admin.index';
    protected $vars;
    protected $content;
    protected $title;

    public function index()
    {
        $this->content =  view('admin.dashboard');
        return $this->renderOutput();
    }

    public function renderOutput()
    {
        $this->vars = array_add($this->vars, 'title', $this->title);

        $navigation = view('admin.navigation')->render();
        $this->vars = array_add($this->vars, 'navigation', $navigation);

        $header = view('admin.header')->render();
        $this->vars = array_add($this->vars, 'header', $header);

        $footer = view('admin.footer')->render();
        $this->vars = array_add($this->vars, 'footer', $footer);
        
        $this->vars = array_add($this->vars, 'content', $this->content);

        return view($this->template)->with($this->vars);
    }
}
