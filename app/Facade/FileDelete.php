<?php

namespace App\Facade;
use Illuminate\Support\Facades\Facade;

class FileDelete extends Facade{
    protected static function getFacadeAccessor(){
      return 'DeleteImg';
    }
}
