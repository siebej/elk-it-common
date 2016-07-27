<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Common;

/**
 * Description of xslFunctions
 *
 * @author Siebe Jongebloed
 */
class BypassView {
    

    public static function message($message=''){
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
