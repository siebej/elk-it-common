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
class Naming {
    
    public static function fromCamelCase($str) {
        $str[0] = strtolower($str[0]);
        return preg_replace_callback('/([A-Z])/',
           create_function ('$matches', 'return \'_\' . strtolower($matches[1]);'), $str);
    }

    public static function toCamelCase($str, $capitaliseFirstChar = true){
        if ($capitaliseFirstChar) {
            $str[0] = strtoupper($str[0]);
        }
        return preg_replace_callback('/(_)([a-z])/',
           create_function ('$matches', 'return strtoupper($matches[2]);'), $str);
    }

    public static function fromDbNameToTitle($str, $capitaliseFirstChar = true){
        if ($capitaliseFirstChar) {
            $str[0] = strtoupper($str[0]);
        }
        return str_replace('_',' ',$str);
    }

    public static function fromObjectToTableName($str) {
        if (strpos($str, 'Model') === 0) {
            return substr(self::fromCamelCase($str), 6);
        } else {
            return self::fromCamelCase($str);
        }
    }

    public static function fromTableToObjectName($str) {
        return 'Model' . self::toCamelCase($str);
    }
    

    public static function filterModel($str) {
        if (strpos($str, 'Model') === 0) {
            return substr($str, 5);
        } else {
            return $str;
        }
    }

    public static function addModel($str) {
        if (strpos($str, 'Model') === 0 && $str !== 'Model') {
            return $str;
        } else {
            return 'Model'.$str;
        }
    }
}
