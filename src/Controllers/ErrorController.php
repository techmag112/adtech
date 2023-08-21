<?php

namespace Tm\Adtech\Controllers;

use League\Plates\Engine;

/**
* Класс контроллера вывода ошибок сервера
*/
class ErrorController {

     /**
    * @var object $templates - экземпляр класса League\Plates\Engine (Шаблоны)
    */
    private $templates;

    /**
    * Метод конструктор класса
    * В нем идет присвоение локальным переменным экземпляров классов из контейнера зависимостей (DI)
    */
    function __construct(Engine $templates) {
        $this->templates = $templates;
     }

    /**
    * mainAction() вывод шаблона ошибки 404
    * @return void
    */
    public function mainAction() {
        echo $this->templates->render('404');   
          
    }
}