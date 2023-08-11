<?php

namespace Tm\Adtech\Core;

class Redirect {
    public static function to($location = '/', $message = null) {

        if($message != null) {
            Session::put('message', $message);
            Session::put('type', 'success');
        }
        header('Location: ' . $location);
        
    }
}