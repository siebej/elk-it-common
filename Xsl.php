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
class Xsl {
    
    public static function substringBefore($hay, $needle) {
        $pos = strpos($hay, $needle);
        if ($pos === FALSE) {
            return FALSE;
        } else {
            return substr($hay, 0, $pos);
        }
    }

    public static function substringAfter($hay, $needle) {
        $pos = strpos($hay, $needle);
        if ($pos === FALSE) {
            return FALSE;
        } else {
            return substr($hay, $pos + strlen($needle));
        }
    }

    public static function contains($hay, $needle) {
        $pos = strpos($hay, $needle);
        if ($pos === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public static function startsWith($haystack, $needle) {
        return strpos($haystack, $needle) === 0;
    }

    public static function endsWith($haystack, $needle) {
        return substr($haystack, - strlen($needle)) == $needle;
    }
    
    public static function lowerCase($string){
        return strtolower($string);
    }

    public static function upperCase($string){
        return strtoupper($string);
    }

    public static function tokenize($string, $token){
        return explode($token,$string);
    }
    
    public static function stringLength($string){
        return strlen($string);
    }
    
    public static function concat(){
        $return='';
        for($i = 0 ; $i < func_num_args(); $i++) {
            $return.= func_get_arg($i);
        }
        return $return;
    }
    
    public static function not($var){
        return !$var;
    }    
    
}
