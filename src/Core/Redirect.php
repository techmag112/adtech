<?php

namespace Tm\Adtech\Core;

/**
 * Статический класс-обертка функции редиректа страницы
 */
class Redirect {

    /**
    * @static to() редирект на указанный урл, по умолчанию '/'
    * @param string $location
    * @param string $message = null
    */
    public static function to($location = '/', $message = null) {

        if($message != null) {
            Session::put('message', $message);
            Session::put('type', 'success');
        }
        header('Location: ' . $location);
        
    }
}