<?php

namespace Tm\Adtech\Core;

/**
 * Статический класс-обертка глобальной переменной _SESSION
 */
class Session {
 
    /**
    * @static put() возвращает значение глобальной переменной _SESSION по имени
    * @param string $name
    * @param mixed $value
    */
    public static function put($name, $value) {
        return $_SESSION[$name] = $value;
    }

    /**
    * @static exists() проверка существования глобальной переменной _SESSION по имени
    * @param string $name
    * @return boolean true:false
    */
    public static function exists($name) {
        return (isset($_SESSION[$name])) ? true : false;
    }

    /**
    * @static delete() удаление глобальной переменной _SESSION по имени
    * @param string $name
    */
    public static function delete($name) {
        if(self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    /**
    * @static get() возврат значения глобальной переменной _SESSION по имени
    * @param string $name
    * @return mixed
    */
    public static function get($name) {
        return $_SESSION[$name];
    }

}