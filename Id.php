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
class Id {
    
    public static function getSmallUuid() {
        return sprintf( '%04x%04x',mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ));
    }

    public static function getUuid() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

            // 16 bits for "time_mid"
            mt_rand( 0, 0xffff ),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand( 0, 0x0fff ) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand( 0, 0x3fff ) | 0x8000,

            // 48 bits for "node"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }


    public static function secureRandomBytes($length = 10,$callCounter=0) {

        /*
         * My primary choice for a cryptographic strong randomness function is
         * openssl_random_pseudo_bytes.
         */
        $SSLstr = FALSE;

        if (function_exists('openssl_random_pseudo_bytes') &&
                (version_compare(PHP_VERSION, '5.3.4') >= 0 ||
                substr(PHP_OS, 0, 3) !== 'WIN')) {
            $SSLstr = openssl_random_pseudo_bytes($length, $strong);
            if ($strong) {
                return substr(base64_encode($SSLstr),0,$length);
            }
        }

        if ($callCounter < 10){
            return self::secureRandomBytes($length,$callCounter++);
        }
        return false;
    }
    

    public static function getTokenValue(){
        return md5(uniqid(rand(), TRUE));
    }

    public static function getAndSetTokenForPostingViaCurl(&$targetDb) {
        $token          = getTokenValue();
        $tokenInsert    = $targetDb->dbInsert('insert into token set waarde="'.$token.'"');
        if(false===$tokenInsert){
            return FALSE;
        } else {
            return $token;
        }
    }
    
}
