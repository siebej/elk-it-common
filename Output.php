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
class Output {
    

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
    
    public static function var_dump($name,$var){
        echo '<p>'.$name.'</p>';
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
    
    public static function print_r($name,$var){
        echo '<p>'.$name.'</p>';
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
 
    public static function echo_p($name,$value){
        echo '<p>'.$name.': '.$value.'</p>';
    }
    

}
