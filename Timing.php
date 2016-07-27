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
class Timing {
    
    private static $times=array();
    private static $startTime;
    private static $lastTime;

    public static function setSessionTimes(){
        self::$times=array();
        self::setSessionLastTime();
    }

    public static function setSessionStartTime(){
        self::$startTime = microtime(TRUE);
    }

    public static function setSessionLastTime(){
        self::$lastTime=microtime(TRUE);
    }

    
    public static function fromFloatToTime($float){
        if(Xsl::contains((string)$float,'.')){
            list($sec, $usec)  = explode('.', $float);
        } else {
            $sec = $float;
            $usec=0;
        }
        return date('H:i:s', $sec) . '.' . str_pad(substr($usec,0,3),3,'0',STR_PAD_LEFT);;
    }

    public static function setTimeDiff($key){
        if(!isset(self::$times)){
            self::setSessionTimes();
        }
        $now        = microtime(TRUE);
        $lastTime   = self::$lastTime;
        self::$lastTime=$now;
        $timeDiff = $now - $lastTime;
        if(array_key_exists($key, self::$times)){
            self::$times[$key]['count']++;
            self::$times[$key]['time']+=$timeDiff;

        }  else {
            self::$times[$key]['count']=1;
            self::$times[$key]['time']=$timeDiff;
        }
    }

    public static function getTimeDiff(){
        $now        = microtime(TRUE);
        $lastTime   = self::$lastTime;
        if($now===$lastTime){
            return 0;
        } else {
            $timeDiff   = $now - $lastTime;
            self::$lastTime=$now;
            return round($timeDiff,3);
        }
    }

    public static function getTimeDiffFromStart($get_as_float=FALSE){
        if (!empty(self::$startTime)){
            $timeDiff = microtime(TRUE)-self::$startTime;
            if($get_as_float){
                return $timeDiff;
            } else {
                return round($timeDiff,3);
            }
            
        }elseif(defined('START_TIME')){
            $timeDiff = microtime(TRUE)-START_TIME;
            if($get_as_float){
                return $timeDiff;
            } else {
                return round($timeDiff,3);
            }
        } else {
            return FALSE;
        }
    }

}
