<?php

namespace App\Helper;

class DeleteImg{
    public static function DeleteImg($path){
       if($path){
           unlink($path);
       }
    }
}
