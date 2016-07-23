<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ElkIt\Common;

/**
 * Description of Session
 *
 * @author Siebe Jongebloed
 */
class Session {

    public static function unsetVar($var){
        if(isset($_SESSION[$var])){
            unset($_SESSION[$var]);
        }
    }
    
    public static function set($name,$value){
        $_SESSION[$name] = $value;
    }

    public static function dontBuildView(){
        self::set('build_view',FALSE);
    }

    public static function addMessage($message){
        if(!empty($_SESSION['message'])){
            $_SESSION['message'] .= PHP_EOL.$message;
        } else{
            $_SESSION['message'] = $message;
        }
    }
    
    public static function message($message,$params=  array()){
        if (empty($params['reloadPageAfterSubmit']) && VIA_AJAX){
    //        print_r_file('paramst',$params);
            self::setAjaxMessage(__($message));
        } else {
            self::setRedirectMessage(__($message));
        }
    }
    
    
    public static function setRedirectMessage($message){
        self::set('redirectMessage',$message);
    }
    
    public static function setAjaxMessage($message){
        self::set('ajaxMessage',$message);
    }
    
    
}
