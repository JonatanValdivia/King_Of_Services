<?php

namespace App\Core;

Class Controller {
  public function model($model){
    require_once '../App/Model/'.$model.'.php';
    return new $model;
  }
}