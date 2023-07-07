<?php

class Pages extends Controller {
    public function __construct(){
    }

    public function index() {
        $data = ['title' => 'Welcome to AtomPHP'];
        $this->view('pages/index', $data);
    }

    public function about(){
        $data = ['title' => 'about us'];
        $this->view('pages/about', $data);
    }
}