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
class DateTime {
    

    public static function dateTimeAsName(){
        return date("Ymd-Hi");
    }
    
    public static function dateTimeSecondsAsName($dateSplitString='',$timeSplitString='',$typeSplitString=''){
        $mask = 'Y'.$dateSplitString.'m'.$dateSplitString.'d'.$typeSplitString.'H'.$timeSplitString.'i'.$timeSplitString.'s';
        return date($mask) . $typeSplitString . substr((string)microtime(), 2, 6);
    }

    public static function datediffTimestampInMinutes($date1, $date2){
        if($date1 > $date2){
            return self::datediffTimestampInMinutes($date2, $date1);
        }
        $first  = \DateTime::createFromFormat('Y-m-d H:i:s', $date1);
        $second = \DateTime::createFromFormat('Y-m-d H:i:s', $date2);
        return floor($first->diff($second)->i);
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

    public static function toReadableTime(){
        list($usec, $sec) = explode(' ', microtime());
        return date('H:i:s', $sec) . substr(str_replace("0.", ".", $usec),0,5);
    }

}
