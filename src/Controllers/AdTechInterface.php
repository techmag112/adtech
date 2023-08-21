<?php

namespace Tm\Adtech\Controllers;

use Delight\Auth\Auth;
use League\Plates\Engine;

use Tm\Adtech\Core\Redirect;
use Tm\Adtech\Core\DBQuery;

/**
* Класс контроллера вывода интерфейсов пользователей
*/
class AdTechInterface {

    /**
    * @var object $auth - экземпляр класса Delight\Auth\Auth (Авторизация)
    * @var object $templates - экземпляр класса League\Plates\Engine (Шаблоны)
    * @var object $db- экземпляр класса DBQuery (класс методов-запросов к базе для внешнего интерфейса)
    */
    private $auth, $templates, $db;

    /**
    * Метод конструктор класса
    * В нем идет присвоение локальным переменным экземпляров классов из контейнера зависимостей (DI)
    */
    function __construct(Engine $templates, Auth $auth, DBQuery $db) {
        $this->templates = $templates;
        $this->auth = $auth;
        $this->db = $db;
    }

    /**
    * checkRole() проверка роли и вызов соотвествующего шаблона
    * @return void
    */
    public function checkRole(): void 
    {
        /** Если есть авторизация - возврат true, иначе - false */
        if ($this->auth->isLoggedIn()) {

            /** Проверка совпадения роли пользователя */
            /** Если есть авторизация - возврат true, иначе - false */
            if ($this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
                echo $this->templates->render('admin');
            /** Заказчик рекламы? */
            } elseif ($this->auth->hasRole(\Delight\Auth\Role::PUBLISHER)) {
                echo $this->templates->render('publisher');
            /** Веб-мастер? */    
            } elseif ($this->auth->hasRole(\Delight\Auth\Role::SUBSCRIBER)) {
                echo $this->templates->render('subscriber');
            } else {
                echo $this->templates->render('wait');
            }
        } else {
            Redirect::to('/login');
        }

    }

    /**
    * actionDB() осуществить асинхронный запрос к базе из внешнего интерфейса через axios
    * @param string $arg - имя метода - запроса к базе
    */
    public function actionDB($arg) {
        call_user_func([$this->db, $arg['action']]);
    }


}