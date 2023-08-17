<?php

namespace Tm\Adtech\Core;

/**
 * Статический класс-обертка переменных get и post
 */
class Input {

    /**
    * @static exists() если глобальная переменная существует, возвращает ее тип - post или get
    * @param string $type
    * @return boolean true|false
    */
    public static function exists($type = 'post') {
        switch ($type) {
            case 'post':
                return (!empty($_POST)) ? true : false;
            case 'get':
                return (!empty($_GET)) ? true : false;
            default:
                return false;
            break;
        }
    }

    /**
    * get() если глобальная переменная существует, возвращает ее значение
    * @param string $item
    * @return mixed|''
    */
    public static function get($item) {
        if(isset($_POST[$item])) {
            return $_POST[$item];
        } else if(isset($_GET[$item])) {
            return $_GET[$item];
        }
        return '';
    }
}