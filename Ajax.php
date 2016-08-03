<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Common;

/**
 * Description of Session
 *
 * @author Siebe Jongebloed
 */
class Ajax {

    private static $_isAjaxRequest=FALSE;

    public static function responseJson($data){
        Session::dontBuildView();
        header($_SERVER["SERVER_PROTOCOL"] . ' 200 OK');
        echo json_encode($data);
        die();
    }
    
    public static function setIsAjaxRequest($isAjaxRequest){
        self::$_isAjaxRequest = $isAjaxRequest;
    }
    
    public static function isAjaxRequest(){
        return self::$_isAjaxRequest;
    }
    
}
