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
class Debug {
    
    private static $handler='session';
    private static $handlers=array('session');
    private static $debugFile=FALSE;
    private static $warningNoDebugFile=FALSE;

    public static function setHandler($handler){
        self::$handler = $handler;
        self::$handlers[] = $handler;
    }

    public static function restoreHandler(){
        $lastHandler=array_pop(self::$handlers);
        $currentHandler= end(self::$handlers);
        self::$handler = $currentHandler;
    }

    public static function setDebugFile($debugFile){
        self::$debugFile = $debugFile;
    }
    
    public static function nameValueToHandler($name,$value,$handler='file'){
        self::setHandler($handler);
        self::nameValue($name, $value);
        self::restoreHandler();
    }

    public static function nameValue($name,$value){
        if (FALSE===DEBUG) {
            return;
        }
        if(Xsl::startsWith($name,'$')){
            $name = substr($name, 1);
        }
        if (is_object($value)){
            self::varDump($name,$value);
        } elseif (is_array($value)) {
            self::handleArray($name,$value);
        } else {
            self::handleSingleValue($name,$value);
        }
    }
    
    private static function handleSingleValue($name,$value){
        self::store($name, $value);
    }

    private static function handleArray($name,$value){
        self::store($name, print_r($value,TRUE), TRUE);
    }
        
    private static function varDump($name,$value){
        ob_start();
        var_dump($value);
        $buffer = ob_get_contents();
        ob_end_clean();
        self::store($name, $buffer, TRUE);
    }
        
    private static function store($name,$value,$pre=FALSE){
        if(self::$handler==='session'){
            self::storeSession($name, $value, $pre);
        } elseif (self::$handler==='file') {
            self::storeFile($name, $value);
        } elseif (self::$handler==='echo') {
            self::storeEcho($name, $value, $pre);
        } elseif (self::$handler==='chrome') {
        
        }
    }
    
    private static function storeEchoPre($name,$value){
        echo '<p>'.$name.'</p>';
        echo '<pre>';
        echo $value;
        echo '</pre>';
    }

    private static function storeEcho($name,$value,$pre=FALSE){
        if ($pre){
            self::storeEchoPre($name, $value);
        } else {
            echo '<p>'.$name.': '.$value.'</p>';
        }
    }

    private static function storeSession($name,$value,$pre=FALSE){
        $_SESSION['debugStrings'][]= array('naam' => $name , 'waarde' => $value ,'pre' => $pre);
    }
    
    private static function storeFile($name,$value){
        if(self::$debugFile){
            file_put_contents(self::$debugFile, $name.': '.$value."\n", FILE_APPEND | LOCK_EX);
        } else {
            if(FALSE===self::$warningNoDebugFile){
                trigger_error('Geen debugFile bekend',E_USER_WARNING);
                self::$warningNoDebugFile = TRUE;
            }
        }
    }
}
