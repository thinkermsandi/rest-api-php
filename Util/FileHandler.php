<?php

namespace Api\Util;

define('UPLOAD_PATH', 'upload/');
define('MAXIMUM_FILESIZE', '10485760'); //10 MB

/**
 * A Utility class for uploading files
 */
class FileHandler {
    
    private $file_types = array('xls', 'xlsx', 'pdf', 'docx', 'doc');
    private $files = null;
    private $filename_sanitized = null;
    private $filename_original = null;
        
        
    public function __construct($files){
        $this->files = $files;    
    }
        
    public function setFileTypes($fileTypes = array()){
        $this->file_types = $fileTypes;
    }
        
    public function setFileNameOriginal($filename){
        $this->filename_original = $filename;
    }
        
    public function fileNameOriginal(){
        return $this->filename_original;
    }
        
    public function sanitize($cursor = 0){
        $this->setFileNameOriginal($this->files['name'][$cursor]);
            
        $safe_filename = preg_replace(
            array("/\s+/", "/[^-\.\w]+/"),
            array("_", ""),
                    trim($this->fileNameOriginal()));
        $this->filename_sanitized  = md5($safe_filename.time()).$safe_filename;
        return $this;
    }
        
    public function fileSize($cursor = 0){
        return $this->files['size'][$cursor];
    }

    public function extensionValid(){
        $fileTypes = implode('|', $this->file_types);
        $rEFileTypes = "/^\.($fileTypes){1}$/i";
        if(!preg_match($rEFileTypes, strrchr($this->filename_sanitized, '.')))
            throw new Exception('No se pudo encontrar el tipo de archivo apropiado');

        return $this;
    }

    public function isUploadedFile($cursor){
        if(!is_uploaded_file($this->files['tmp_name'][$cursor]))
        {
            throw new Exception("No se obtuvo la carga del archivo");
        }
    }

    public function saveUploadedFile($cursor){
        if(!move_uploaded_file ($this->files['tmp_name'][$cursor],UPLOAD_PATH.$this->filename_sanitized))
            throw new Exception("No se consigui&oacute; guardar el archivo");
    }

    public function fileNameSanitized(){
        return $this->filename_sanitized;
    }

    public function uploadFile($cursor = 0){
        $this->isUploadedFile($cursor);
        if ($this->sanitize($cursor)->fileSize($cursor) <= MAXIMUM_FILESIZE)
        {
            $this->extensionValid()->saveUploadedFile($cursor);
        }
        else 
        {
            throw new Exception("El archivo es demasiado grande.");
        }
        return $name;            
    }
    
}
