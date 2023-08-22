<?php

namespace Tm\Adtech\Core;

use FastRoute;
use DI\ContainerBuilder;
use PDO;
use Delight\Auth\Auth;
use Delight\Db\PdoDatabase;
use League\Plates\Engine;
use \Tm\Adtech\Controllers\AdtechInterface;
use \Tm\Adtech\Controllers\LoginController;
use \Tm\Adtech\Controllers\ErrorController;
use \Tm\Adtech\Controllers\UserDataController;
use \Tm\Adtech\Controllers\ReferLinkController;
use \Tm\Adtech\Core\Redirect;

/**
 * Класс роутера-маршрутизатора
 */
class Router {

    /**
    * @static run() создает контейнер DI (внедрения зависимостей) и запускает роутер
    */
    public static function run() {

         /** Сбор всех зависимостей в контейнер */
         /** Объявляем контейнер */
         $builder = new ContainerBuilder();
        /** Собираем к него зависимости - создаем экземпляр каждого класса зависимости со всеми настройками */
         $builder->addDefinitions([
             Engine::class => function() { 
                 return new Engine('../src/Templates');
             },

             PDO::class => function() {
                 $driver = "mysql";
                 //$host = "localhost";
                 //$port = 3400;
                 //$username = "root";
                 //$password = "";
                 $host = "db";
                 $port = 3306;
                 $username = "admin";
                 $password = "12345";
                 $database_name = "adtech";
                 $mypdo = new PDO("$driver:host=$host:$port;dbname=$database_name", $username, $password);
                 return $mypdo;
             },

             PdoDatabase::class => function($container) {
                 return PdoDatabase::fromPdo($container->get('PDO'));
              },

              Auth::class => function($container) {
                  return new Auth($container->get('PDO'));
             }

        ]); 
        /** Создаем экземпляр контейнера */
        $container = $builder->build();
       
        $dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
            /** Маршруты авторизации */
            /** показ формы регистрации */
             $r->addRoute('GET', '/register', ['Tm\Adtech\Controllers\LoginController', 'reg_form_view']);
             /** процедура регистрации */
             $r->addRoute('POST', '/register', ['Tm\Adtech\Controllers\LoginController', 'isRegistration']);
             /** показ формы обновления имени пользователя */
             $r->addRoute('GET', '/update', ['Tm\Adtech\Controllers\UserDataController', 'update_view']);
             /** процедура обновление пароля */
             $r->addRoute('POST', '/update', ['Tm\Adtech\Controllers\UserDataController', 'update']);
             /** показ формы изменения пароля */
             $r->addRoute('GET', '/changepass', ['Tm\Adtech\Controllers\UserDataController', 'changepass_view']);
             /** процедура изменение пароля */
             $r->addRoute('POST', '/changepass', ['Tm\Adtech\Controllers\UserDataController', 'changepass']);
             /** показ формы логина */
             $r->addRoute('GET', '/login', ['Tm\Adtech\Controllers\LoginController', 'login_form_view']);
             /** процедура логина */
             $r->addRoute('POST', '/login', ['Tm\Adtech\Controllers\LoginController', 'login']);
             /** процедура логута */
             $r->addRoute('GET', '/logout', ['Tm\Adtech\Controllers\LoginController', 'logout']);
            /** вывод шаблона страницы ршибка 404 */
             $r->addRoute('GET', '/404', ['Tm\Adtech\Controllers\ErrorController', 'mainAction']);
            /** запрос из внешнего интерфейса по методу get */
             $r->addRoute('GET', '/get/{action:\w+}', ['Tm\Adtech\Controllers\AdTechInterface', 'actionDB']);
             /** запрос из внешнего интерфейса по методу post */
             $r->addRoute('POST', '/post/{action:\w+}', ['Tm\Adtech\Controllers\AdTechInterface', 'actionDB']);
            /** обработка реферального линка */
             $r->addRoute('GET', '/ref={ref:\d+},off={off:\d+}', ['Tm\Adtech\Controllers\ReferLinkController', 'gotoReferLink']);
            /** вывод шаблона интерфейса по итогам проверки роли пользователя */
             $r->addRoute('GET', '/', ['Tm\Adtech\Controllers\AdTechInterface', 'checkRole']);
        
        });

        // Fetch method and URI from somewhere
         $httpMethod = $_SERVER['REQUEST_METHOD'];
         $uri = $_SERVER['REQUEST_URI'];
        
        // Strip query string (?foo=bar) and decode URI
         if (false !== $pos = strpos($uri, '?')) {
             $uri = substr($uri, 0, $pos);
         }
         $uri = rawurldecode($uri);
     
         $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

         switch ($routeInfo[0]) {
             case FastRoute\Dispatcher::NOT_FOUND:
                 Redirect::to('404');
                 //echo '404 Not Found';
                 break;
             case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                 $allowedMethods = $routeInfo[1];
                 echo '405 Method Not Allowed';
                 break;
             case FastRoute\Dispatcher::FOUND:
                 $handler = $routeInfo[1];
                 $vars = $routeInfo[2];
                 
                 $container->call($handler, [$vars]);
                 break;
        }    
    }
}