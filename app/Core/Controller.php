<?php
namespace App\Core;

class Controller {
    public function model($model) {
        require_once APPROOT . '/Models/' . $model . '.php';
        $modelClass = "App\Models\\" . $model;
        return new $modelClass();
    }

    public function view($view, $data = []) {
        extract($data);
        require_once APPROOT . '/Views/' . $view . '.php';
    }
}
