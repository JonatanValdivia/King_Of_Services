<?php 

namespace App\Core;
//
class Model {
    private static $conection;
    public static function getConn(){
        if(!isset(self::$conection)){
            self::$conection = new \PDO('mysql:host=localhost;port=3306;dbname=king_of_services', 'root', 'bcd127');
        }
        return self::$conection;
    }
}
