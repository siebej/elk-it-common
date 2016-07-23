<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ElkIt\Common;

/**
 * Description of xslFunctions
 *
 * @author Siebe Jongebloed
 */
class Server {

    public static function getMacAddresses(){
        $command = 'ifconfig | grep HWaddr';
        $addressesFromShell = self::logErrorShellExec($command);
        $addresses = array();
        if(is_array($addressesFromShell)){
            foreach ($addressesFromShell as $addressFromShell) {
                if($addressFromShell){
                    $addresses[Xsl::substringBefore($addressFromShell, ' ')]= Xsl::substringAfter($addressFromShell, 'HWaddr ');
                }
            }
            return $addresses;
        } else {
            return $addressesFromShell;
        }
    }
    
    public static function logErrorShellExec($command,$echoResult=FALSE){
    $command        = $command.' 2>&1';
//    echo_c('command', $command);
    $result         = explode("\n",shell_exec($command));
    if($echoResult){
        print_r_c('result', $result);
    }
    $firstResult    = $result[0];

    if (Xsl::contains($firstResult, 'not permitted') || Xsl::contains($firstResult,'command not found')){
        trigger_error('command: '.$command.'. geeft fout: ' . $firstResult,E_USER_ERROR);
    }
    return $result;
}

}
