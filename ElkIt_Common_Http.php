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
class Http {

    public static function getUploadMaxFilesizeInBytes(){
        return get_bytes(ini_get('upload_max_filesize'));
    }

    public static function getPostMaxSizeInBytes(){
        return get_bytes(ini_get('post_max_size'));
    }

    public static function getMaxFileUploads(){
        return ini_get('max_file_uploads');
    }

    public static function getAsync($url, $arguments){
        $command = 'wget -b -O /dev/null -o /dev/null --post-data "'. http_build_query($arguments) .'" '.$url;
        exec($command);
    }

    public static function postDataViaCurl($url, $data, &$response, $timeout=5000) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER ,1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,$timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS     ,$timeout);
        curl_setopt($ch, CURLOPT_POST           ,1);

        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
        $response = trim(curl_exec($ch));

        if (curl_errno($ch)||!$response) {
            echo_file('curl-err',curl_errno($ch));
            return $ch;
        } else {
            curl_close($ch);
            return TRUE;
        }
    }

    public static function download($file){
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Connection: Keep-Alive');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        header('Content-Type: '   . getMimeType($file));
        $fp = fopen($file, 'rb');
        fpassthru($fp);
    }

    
}
