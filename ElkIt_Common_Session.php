<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ElkIt\Common;

/**
 * Description of Session
 *
 * @author Siebe Jongebloed
 */
class Session {

    public static function unsetSessionVar($var){
        if(isset($_SESSION[$var])){
            unset($_SESSION[$var]);
        }
    }
}
