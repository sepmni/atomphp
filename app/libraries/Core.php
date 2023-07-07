<?php

//  creates url and loads controllers
class Core
{
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct(){
        // print_r($this->getURL());
        $url = $this->getURL();

        // find it in controller in first index
        if(file_exists('../app/controllers/' . ucwords($url[0]) . '.php')){
            // if exists, set as controller
            $this->currentController = ucwords($url[0]);

            // unset 0 index
            unset($url[0]);
        }
        // require the controller
        require_once '../app/controllers/' . $this->currentController . '.php';

        // instantiate
        $this->currentController = new $this->currentController;

        // check for second part
        if(isset($url[1])){
            // check if method exists
            if(method_exists($this->currentController, $url[1])){
                $this->currentMethod = $url[1];
                // unset 1 
                unset($url[1]);
            }
        }
        // get params
        $this->params = $url ? array_values($url) : [];

        // call 
        call_user_func_array([
            $this->currentController,
            $this->currentMethod
        ], $this->params);
    }

    public function  getURL()
    {
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}
