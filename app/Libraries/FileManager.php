<?php
/**
 * Created by PhpStorm.
 * User: mithredate
 * Date: 2016-06-13
 * Time: 2:10 PM
 */

namespace App\Libraries;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileManager
{


    protected $image_mime_types;

    protected $image_directory;

    public $ERROR_OCCURRED_SAVING;
    public $INVALID_FILE;
    public $INVALID_FILE_TYPE;
    public $SAVED_SUCCESSFULLY;


    public function __construct()
    {
        $this->image_directory = app('filesystem')->disk('gallery')->getDriver()->getAdapter()->getPathPrefix();
        $this->image_mime_types = ['image/gif', 'image/jpeg', 'image/png', 'image/bmp'];

        $this->ERROR_OCCURRED_SAVING = 11;
        $this->INVALID_FILE = 12;
        $this->INVALID_FILE_TYPE = 13;
        $this->SAVED_SUCCESSFULLY = 0;
    }




    public function uploadImage(UploadedFile $file, $filename = null){
        if (! $file->isValid()) {
            return $this->prepareResponse($this->INVALID_FILE);
        }
        if( ! in_array($file->getClientMimeType(), $this->image_mime_types) ) {
            return $this->prepareResponse($this->INVALID_FILE_TYPE);
        }
        $filename = $this->getFileName($file, $filename);
        $file->move($this->image_directory , $filename );
        return $this->prepareResponse($this->SAVED_SUCCESSFULLY, 'Image Uploaded Successfully', compact('filename'));
    }

    private function getFileName(UploadedFile $file, $filename){
        return time(). '_' . ($filename ? $filename . '.' .  $file->getClientOriginalExtension() : $file->getClientOriginalName());
    }

    private function prepareResponse($status, $message = '', $data = []){
        return [
            'status' => $status,
            'message' => $message,
            'data' => json_encode($data)
        ];
    }

    public function getFileNameFromResponse($response){
        $data = json_decode($response['data']);
        if($data->filename){
            return $data->filename;
        }
        return '';
    }

    public function deleteImage($filename){
        $fullName = $this->image_directory . PATH_SEPARATOR . $filename;
        if( file_exists( $fullName ) ){
            unlink( $fullName );
        }
    }
}