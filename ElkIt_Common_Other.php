<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ElkIt\Common;

/**
 * Description of xslFunctions
 *
 * @author Siebe Jongebloed
 */
class Other {
    

    public static function getBytes($val) {
        $val = trim($val);
        $last = strtolower($val[strlen($val)-1]);
        switch($last) {
            // The 'G' modifier is available since PHP 5.1.0
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }

        return $val;
    }

    public static function createHierarchyFromPath($arrayFlat){
        $arrayMulti = array();
        foreach ($arrayFlat as $record){
            $pathParts  = explode('.', $record['path']);
            if(isset($pathParts[7])){
                $arrayMulti[$pathParts[0]] [$pathParts[1]] [$pathParts[2]] [$pathParts[3]] [$pathParts[4]] [$pathParts[5]] [$pathParts[6]] [$pathParts[7]][] =$record;
            }elseif (isset($pathParts[6])){
                $arrayMulti[$pathParts[0]] [$pathParts[1]] [$pathParts[2]] [$pathParts[3]] [$pathParts[4]] [$pathParts[5]] [$pathParts[6]][] =$record;
            }elseif (isset($pathParts[5])){
                $arrayMulti[$pathParts[0]] [$pathParts[1]] [$pathParts[2]] [$pathParts[3]] [$pathParts[4]] [$pathParts[5]][] =$record;
            }elseif (isset($pathParts[4])){
                $arrayMulti[$pathParts[0]] [$pathParts[1]] [$pathParts[2]] [$pathParts[3]] [$pathParts[4]][] =$record;
            }elseif (isset($pathParts[3])){
                $arrayMulti[$pathParts[0]] [$pathParts[1]] [$pathParts[2]] [$pathParts[3]][] =$record;
            }elseif (isset($pathParts[2])){
                $arrayMulti[$pathParts[0]] [$pathParts[1]] [$pathParts[2]][] =$record;
            }elseif (isset($pathParts[1])){
                $arrayMulti[$pathParts[0]] [$pathParts[1]][] =$record;
            }else{
                $arrayMulti[$pathParts[0]][] =$record;
            }
        }

        return $arrayMulti;
    }

    public static function getServerName() {
        if(Check::isCommandLineInterface()){
            return php_uname("n");

        } elseif ($host = $_SERVER['HTTP_X_FORWARDED_HOST']) {
            $elements = explode(',', $host);

            $host = trim(end($elements));
        } else {
            if (!$host = $_SERVER['HTTP_HOST']) {
                if (!$host = $_SERVER['SERVER_NAME']) {
                    $host = !empty($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '';
                }
            }
        }

        // Remove port number from host
        $host = preg_replace('/:\d+$/', '', $host);

        return trim($host);
    }
    
    public static function end($message=''){
        if(!empty($message)){
            echo '<pre>';
            if(is_array($message)||  is_object($message)){
                print_r($message);
            }else{
                echo $message.EOL;
            }
        }
        Session::dontBuildView();
        die();
        
    }
    public static function endWithHtmlOutput($html){
        echo $html.EOL;
        Session::dontBuildView();
        die();
    }
    
    public static function endWithPlainMessage($message){
        if(is_array($message)||  is_object($message)){
            print_r($message);
        }else{
            echo $message.PHP_EOL;
        }
        Session::dontBuildView();
        die();
    }

}
