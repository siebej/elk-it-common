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
class Session {

    public static function unsetVar($var){
        if(isset($_SESSION[$var])){
            unset($_SESSION[$var]);
        }
    }
    
    public static function get($name){
        if(isset($_SESSION[$name])){
            return $_SESSION[$name];
        } else {
            return FALSE;
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
        if (empty($params['reloadPageAfterSubmit']) && Ajax::isAjaxRequest()){
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
    
    /**
     * 
     * @param type $returnType
     * @return type
     * Functie is ontstaan vanuit behoefte om van een url 
     * in de vorm van index.php?model=User&id=123456 seo friendly te maken 
     * in de vorm van /model/User/id/123456
     * Om te herkennen of dit actief is zetten we in .htaccess iets als RewriteRule ^(.*)$ /index.php?seo-qs=$1 [L,QSA]
     * En dient in de apche config file .htaccess actief te zijn m.b.v. AllowOverride All in de <Directory "/var/www/html"> tag
     */
    public static function seoQsEnabled($returnType='string'){
        if(!empty($_GET['seo-qs'])){
            $_SESSION['seoQsEnabled'] = TRUE;
        }
        if(isset($_SESSION['seoQsEnabled'])){
            return Convert::bool(TRUE,$returnType);
        } else {
            return Convert::bool(FALSE,$returnType);
        }
    }
    
}
