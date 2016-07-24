<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Common;

require_once(ROOT_PATH.'lib/Encoding.php'); 
use \ForceUTF8\Encoding;  // It's namespaced now.


/**
 * Description of xslFunctions
 *
 * @author Siebe Jongebloed
 */
class Convert {
    

    public static function toNummeric(&$input,$europeanInput){
        if ($europeanInput){
            $input = floatval(str_replace(',', '.', str_replace('.', '', $input)));
        }
    }
    
    public static function checkYear($year) {
        if (is_unsigned_int($year) === FALSE) {
            return FALSE;
        } else {
            if (strlen($year) === 2) {
                if ($year > 30) {
                    $year = '19' . $year;
                } else {
                    $year = '20' . $year;
                }
                return $year;
            } elseif (strlen($year) === 4 && self::between($year, 1900, 2030)) {
                return $year;
            } else {
                return FALSE;
            }
        }
    }

    public static function formatSql($sql){
        if(class_exists('SqlFormatter')){
            return SqlFormatter::format($sql, false);
        } else {
            return $sql;
        }
    }

    public static function serializeForUTF8fDb($object){
        return base64_encode(serialize($object));
    }

    public static function unserializeFromUTF8Db($string){
        return unserialize(base64_decode($string));
    }

    public static function convertToUtf8($value){
        $encodings = array('UTF-8', 'ISO-8859-1', 'WINDOWS-1251');
        $encoding = mb_detect_encoding($value, $encodings, true);
        switch ($encoding) {
            case FALSE:
                $value = utf8_encode($value);
                break;
            case 'ISO-8859-1':
            case 'WINDOWS-1251':
                $value = mb_convert_encoding($value, "UTF-8", $encoding);
                break;
            default:
                break;
        }
        return $value;
    }
    
    public static function validUTF8XMLFilter ($in) {
        return preg_replace ('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', '', $in);
    }
    
    public static function fixUTF8($str){
        return Encoding::fixUTF8($str);
    }

    public static function toUTF8($str){
        return Encoding::toUTF8($str);
    }
    
    
    /*
     * xmlFileToArray doet zijn naam eer aan ;-)
     * Zie http://stackoverflow.com/questions/6578832/how-to-convert-xml-into-array-in-php
     */
    public static function xmlFileToArray($file){
        return json_decode(json_encode((array) simplexml_load_file($file,null, LIBXML_NOCDATA)),TRUE);
    }
    
    /*
     * @normalizeArray zorgt voor het aanmaken van een extra nummerieke array-laag voor elementen die meerdere siblings KUNNEN hebben, maar NIET hebben.
     * xmlFileToArray verzamelt bij meer dan 1 kind de kinderen m.b.v. een nummerieke index-array
     * Om overal met kinderen om te gaan stoppen we hier i.h.g.v. geen kinderen de array in een kind
     */
    public static function normalizeArray($arrayIn){
        
        if(is_string($arrayIn)||(is_array($arrayIn) && false===is_int(key($arrayIn)))){
            $arrayOut[0]=$arrayIn;
        } else {
            $arrayOut=$arrayIn;
        }
        return $arrayOut;
    }
    
    public static function encrypt($password,$salt       = 'xedC7h198Ged1') {
        $iterations = 10;
        $hash       = crypt($password, $salt);
        for ($i = 0; $i < $iterations; ++$i) {
            $hash = crypt($hash . $password, $salt);
        }
        return $hash;
    }
    
    public static function vprintf($stringIn, $arguments) {
        $return = '';
        if (DEBUG) {
            $return.= "\n" . '<!--' . "\n";
        }
        $return.= vprintf($stringIn, $arguments);
        if (DEBUG) {
            $return.= '-->' . "\n";
        }
        return $return;
    }
    

}
