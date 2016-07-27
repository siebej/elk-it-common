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
class Inform {
    
    public static function errorMessage($message){
        if(VIA_AJAX){
            if (!empty($_SESSION['sqlError'])) {
                unset($_SESSION['sqlError']);
            }
            Ajax::responseJson(array('ServerError'=>  $message ));
        } else{
            $_SESSION['errorMessage'] = $message;
        }
        
    }
}
