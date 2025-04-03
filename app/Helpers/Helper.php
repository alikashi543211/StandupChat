<?php

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

if(!function_exists('uploadFile')){
    function uploadFile($file, $path, $name)
    {
        $path = $path . '/' . date('Y') . '/' . date('m') . '/';
        $filename = time().'-'.Str::random(4).'-'.$name.'.'.$file->getClientOriginalExtension();
        $file->move($path, $filename);
        return $path.'/'.$filename;
    }
}

if(!function_exists('successMessage')){
    function successFlashMessage($message)
    {
        Session::flash("success_message", $message);
    }
}

if(!function_exists('errorMessage')){
    function errorFlashMessage($message)
    {
        Session::flash("error_message", $message);
    }
}
