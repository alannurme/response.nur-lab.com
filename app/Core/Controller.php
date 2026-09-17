<?php
namespace App\Core;

class Controller extends \CodeIgniter\Controller {
    public function model($model) {
        $modelClass = "App\Models\\" . $model;
        if (!class_exists($modelClass)) {
            require_once APPROOT . '/Models/' . $model . '.php';
        }
        return new $modelClass();
    }

    public function view($view, $data = []) {
        extract($data);
        require_once APPROOT . '/Views/' . $view . '.php';
    }
}

