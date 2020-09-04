<?php
namespace App;

class Router {
    static $pages = [];
    static function __callStatic($name, $args){
        if(strtolower($_SERVER['REQUEST_METHOD']) === $name){
            self::$pages[] = $args;
        }
    }

    static function connect(){
        $url = explode("?", $_SERVER['REQUEST_URI'])[0];

        foreach(self::$pages as $page){
            if($page[0] === $url){
                if(isset($page[2]) && $page[2] === "user" && !user()) go("/", "로그인해 주세요.");
                $action = explode("@", $page[1]);
                $conName = "Controller\\{$action[0]}";
                $con = new $conName();
                $con->{$action[1]}();
                exit;
            }
        }
        http_response_code(404);
    }
}