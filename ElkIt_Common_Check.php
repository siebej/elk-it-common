<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ElkIt\Common;
use ElkIt\Common;
/**
 * Description of xslFunctions
 *
 * @author Siebe Jongebloed
 */
class Check {
    
    public static function ifNull($subject,$alt){
        if(is_null($subject)){
            return $alt;
        }  else {
            return $subject;
        }
    }
    
    public static function isNotNull($var) {
        if (!is_null($var)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    

    /**
     * in tegenstelling tot empty() die false en 0 als leeg ziet, geeft isEmty alleen echt leeg terug
     * @param type $var
     * @return boolean
     */
    public static function isEmpty($var) {
        if ($var === '' || is_null($var)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function isEmptyIndex($array,$index){
        if(isset($array[$index])){
            return self::isEmpty($array[$index]);
        } else {
            return TRUE;
        }
        
    }
    
    public static function dbValueEqualsUserInput($type,$db,$input){
        if (Xsl::endsWith($type, 'int')){
            if ($db===0 && $input===''){
                return FALSE;
            } elseif ($db===NULL && $input==='0') {
                return FALSE;
            } else {
                return $db==$input;
            }
        }  elseif ((Xsl::endsWith($type, 'char') || Xsl::endsWith($type, 'text')) && strpos($db, "\n")!==FALSE && strpos($input, "\n")!==FALSE){
            $brs    = array("\r\n", "\n", "\r");
            $db     = str_replace($brs, "\n", $db);
            $input  = str_replace($brs, "\n", $input);
            return $db==$input;

        } else{
            return $db==$input;
        }
    }


    public static function isUnsignedInt($value) {
        return ctype_digit((string) $value);
    }

    public static function isInt($value) {
        return ($value !== true) && ((string) (int) $value) === ((string) $value);
    }

    public static function isNummeric(&$input,$europeanInput){
        if ($europeanInput){
            $input = floatval(str_replace(',', '.', str_replace('.', '', $input)));
        }
        return(is_numeric($input));
    }

    
    public static function isPingable($ip) {
        $pingresult = exec("/bin/ping -n 3 $ip", $outcome, $status);
        return $status==0;
    }
    
    public static function indexIsTrue($array,$index){
        if(isset($array[$index]) && $array[$index]===TRUE){
            return TRUE;
        }  else {
            return FALSE;
        }
    }
    
    public static function between($int, $min, $max) {
        return ($int >= $min && $int <= $max);
    }


    public static function isArrayWithContent($var){
        return is_array($var) && count($var)>0;
    }

    public static function isUTF8($string) {
        return (utf8_encode(utf8_decode($string)) == $string);
    }
    
    public static function isCommandLineInterface(){
        return (php_sapi_name() === 'cli');
    }
    
    public static function isDate($date,$format='Y-m-d\TH:i:s\Z'){
        $d = DateTime::createFromFormat($format, $date);
        if($d && $d->format($format) === $date){
            return $d;
        } else {
            return FALSE;
        }
    }
    
}
