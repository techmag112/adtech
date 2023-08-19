<?php

namespace Tm\Adtech\Core;

/**
 * Статический класс защитного токена для формы ввода
 */
class Token {

    /**
    * @static generate() возвращает рандомно сгенерированный токен для встраивания в форму
    * @return string
    */
    public static function generate() {
        return Session::put('token', md5(uniqid() . 'salt' . time()));
    }

    /**
    * @static check() проверяет токен в форме и в глобальной переменной на совпадение
    * @param string $token - токен
    * @return boolean true|false
    */
    public static function check($token) {
        $tokenName = 'token';

        if(Session::exists($tokenName) && $token == Session::get($tokenName)) {
            Session::delete($tokenName);
            return true;
        }
        return false;
    }
    
}