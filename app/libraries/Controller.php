<?php

// base controller class that loads models and views
class Controller {
    // load model
    protected function model($model) {
        // require model file
        require_once '../app/models/' .  $model . '.php';
        // instantiate
        return new $model();
    }

    // load view
    protected function view($view, $data = []) {
        // check file exist
        if(file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        }else{
            die('view does not exist');
        }
    }
}