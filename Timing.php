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

    public static function setSessionTimes(){
        $_SESSION['times']=array();
        self::setSessionLastTime();
    }

    public static function setSessionLastTime(){
        $_SESSION['lastTime']=microtime(TRUE);
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
        if(!isset($_SESSION['times'])){
            self::setSessionTimes();
        }
        $now        = microtime(TRUE);
        $lastTime   = $_SESSION['lastTime'];
        $_SESSION['lastTime']=$now;
        $timeDiff = $now - $lastTime;
        if(array_key_exists($key, $_SESSION['times'])){
            $_SESSION['times'][$key]['count']++;
            $_SESSION['times'][$key]['time']+=$timeDiff;

        }  else {
            $_SESSION['times'][$key]['count']=1;
            $_SESSION['times'][$key]['time']=$timeDiff;
        }
    }

    public static function getTimeDiff(){
        $now        = microtime(TRUE);
        $lastTime   = $_SESSION['lastTime'];
        if($now===$lastTime){
            return 0;
        } else {
            $timeDiff   = $now - $lastTime;
            $_SESSION['lastTime']=$now;
            return round($timeDiff,5);
        }
    }

    public static function getTimeDiffFromStart($get_as_float=FALSE){
        if (defined('START_TIME')){
            $timeDiff = microtime(TRUE)-START_TIME;
            if($get_as_float){
                return $timeDiff;
            } else {
                return round($timeDiff,5);
            }
        } else {
            return FALSE;
        }
    }

}
