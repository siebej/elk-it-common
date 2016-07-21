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
class File {
    
    public static function zip($source, $destination) {
        if (!extension_loaded('zip') || !file_exists($source)) {
            return FALSE;
        }

        $zip = new ZipArchive();
        if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
            return FALSE;
        }

        $source = str_replace('\\', '/', realpath($source));

        if (is_dir($source) === TRUE) {

            $dirIt = new RecursiveDirectoryIterator($source);
            $files = new RecursiveIteratorIterator($dirIt, RecursiveIteratorIterator::SELF_FIRST);

            foreach ($files as $file) {
                if (in_array($file->getFilename(), array('.', '..', '.DS_Store'))) {
                    continue;
                }

                if ($file->isDir()) {
                    $zip->addEmptyDir(substringAfter($file, $source . '/'));
                } else {
                    $zip->addFile($file, substringAfter($file, $source . '/'));
                }
            }
        } else if (is_file($source) === TRUE) {
            $zip->addFromString(basename($source), file_get_contents($source));
        }

        return $zip->close();
    }

    public static function createDirIfNotExists($target,$mode='0755') {
        if(!is_dir($target) && !is_file($target) && !is_link($target)){
            if (!@mkdir($target,$mode,TRUE)) {
                $error = error_get_last();
                trigger_error('Het Pad >'. $target .' kan niet geschreven worden. Reden ' . $error, E_USER_WARNING);
                return false;
            }
        }
        return TRUE;
    }

    public static function copyDir($source, $target) {
        $dirIt = new RecursiveDirectoryIterator($source);
        $files = new RecursiveIteratorIterator($dirIt, RecursiveIteratorIterator::SELF_FIRST);
        @mkdir($target);

        foreach ($files as $file) {
            if (in_array($file->getFilename(), array('.', '..', '.DS_Store'))) {
                continue;
            }
            $sourceItem = $file->getRealPath();
            $targetItem = $target . substringAfter($file->getRealPath(), $source);
            if ($file->isDir() === FALSE) {
                copy($sourceItem, $targetItem);
            } else {
                @mkdir($targetItem);
            }
        }
    }
    
    public static function createDir($directory){
        if (!file_exists($directory)) {
            if (!mkdir($directory, 0777, true)) {
                return FALSE;
            }
        }
        return TRUE;
    }

    public static function deleteDir($directory) {
        if (!file_exists($directory)) {
            return;
        }
        $dirIt = new RecursiveDirectoryIterator($directory);
        $files = new RecursiveIteratorIterator($dirIt, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if ($file->getFilename() === '.' || $file->getFilename() === '..') {
                continue;
            }
            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($directory);
    }

    public static function getMimetype($filepath) {
        if(!preg_match('/\.[^\/\\\\]+$/',$filepath)) {
            return finfo_file(finfo_open(FILEINFO_MIME_TYPE), $filepath);
        }
        switch(strtolower(preg_replace('/^.*\./','',$filepath))) {
            // START MS Office 2007 Docs
            case 'docx':
                return 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
            case 'docm':
                return 'application/vnd.ms-word.document.macroEnabled.12';
            case 'dotx':
                return 'application/vnd.openxmlformats-officedocument.wordprocessingml.template';
            case 'dotm':
                return 'application/vnd.ms-word.template.macroEnabled.12';
            case 'xlsx':
                return 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
            case 'xlsm':
                return 'application/vnd.ms-excel.sheet.macroEnabled.12';
            case 'xltx':
                return 'application/vnd.openxmlformats-officedocument.spreadsheetml.template';
            case 'xltm':
                return 'application/vnd.ms-excel.template.macroEnabled.12';
            case 'xlsb':
                return 'application/vnd.ms-excel.sheet.binary.macroEnabled.12';
            case 'xlam':
                return 'application/vnd.ms-excel.addin.macroEnabled.12';
            case 'pptx':
                return 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
            case 'pptm':
                return 'application/vnd.ms-powerpoint.presentation.macroEnabled.12';
            case 'ppsx':
                return 'application/vnd.openxmlformats-officedocument.presentationml.slideshow';
            case 'ppsm':
                return 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12';
            case 'potx':
                return 'application/vnd.openxmlformats-officedocument.presentationml.template';
            case 'potm':
                return 'application/vnd.ms-powerpoint.template.macroEnabled.12';
            case 'ppam':
                return 'application/vnd.ms-powerpoint.addin.macroEnabled.12';
            case 'sldx':
                return 'application/vnd.openxmlformats-officedocument.presentationml.slide';
            case 'sldm':
                return 'application/vnd.ms-powerpoint.slide.macroEnabled.12';
            case 'one':
                return 'application/msonenote';
            case 'onetoc2':
                return 'application/msonenote';
            case 'onetmp':
                return 'application/msonenote';
            case 'onepkg':
                return 'application/msonenote';
            case 'thmx':
                return 'application/vnd.ms-officetheme';
                //END MS Office 2007 Docs

        }
        return finfo_file(finfo_open(FILEINFO_MIME_TYPE), $filepath);
    }

    public static function getFileExtension($file){
        return strtolower(preg_replace('/^.*\./','',$file));
    }

    public static function recursiveGlob($path='',$pattern='*' ) {
        $paths = glob($path.'*', GLOB_MARK|GLOB_ONLYDIR|GLOB_NOSORT);
        $files = glob($path.$pattern, GLOB_BRACE);
        foreach ($paths as $path) {
            $files = array_merge($files,recursiveGlob($path, $pattern));
        }
        return $files;
    }

    public static function getFilesFromDir($dir,$extension=FALSE) {

        $files = array();
        if (is_dir($dir) && $handle = opendir($dir)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != ".." && ($extension===FALSE || endsWith($file, $extension))) {
                    $files[] = $dir . '/' . $file;
                }
            }
            closedir($handle);
        }
        return $files;
    }


    public static function getFileNameFromString($string){
        // Remove anything which isn't a word, whitespace, number
        // or any of the following caracters -_~,;:[]().
        $fileNameCleanedFirstStep = preg_replace("([^\w\s\d\-_~,;:\[\]\(\).])", '', $string);
        // Remove any runs of periods (thanks falstro!)
        $fileNameCleanedSecondStep = preg_replace("([\.]{2,})", '', $fileNameCleanedFirstStep);
        return $fileNameCleanedSecondStep;
    }    
}
