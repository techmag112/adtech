<?php

namespace Tm\Adtech\Core;

use FastRoute;
use DI\ContainerBuilder;
use PDO;
use Delight\Auth\Auth;
use Delight\Db\PdoDatabase;
use League\Plates\Engine;
use \Tm\Adtech\Controllers\AdtechEngine;
use \Tm\Adtech\Controllers\LoginController;
use \Tm\Adtech\Controllers\ErrorController;
use \Tm\Adtech\Controllers\UserDataController;
use \Tm\Adtech\Controllers\ReferLinkController;
use \Tm\Adtech\Core\Redirect;

class Router {

    public static function run() {

         $builder = new ContainerBuilder();
         $builder->addDefinitions([
             Engine::class => function() { 
                 return new Engine('../src/Templates');
             },

             PDO::class => function() {
                 $driver = "mysql";
                 $host = "localhost";
                 $port = 3400;
                 $database_name = "adtech";
                 $username = "root";
                 $password = "";
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

        $container = $builder->build();
       
        $dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
            // Авторизация
             $r->addRoute('GET', '/register', ['Tm\Adtech\Controllers\LoginController', 'reg_form_view']);
             $r->addRoute('POST', '/register', ['Tm\Adtech\Controllers\LoginController', 'isRegistration']);
             $r->addRoute('GET', '/update', ['Tm\Adtech\Controllers\UserDataController', 'update_view']);
             $r->addRoute('POST', '/update', ['Tm\Adtech\Controllers\UserDataController', 'update']);
             $r->addRoute('GET', '/changepass', ['Tm\Adtech\Controllers\UserDataController', 'changepass_view']);
             $r->addRoute('POST', '/changepass', ['Tm\Adtech\Controllers\UserDataController', 'changepass']);
             $r->addRoute('GET', '/login', ['Tm\Adtech\Controllers\LoginController', 'login_form_view']);
             $r->addRoute('POST', '/login', ['Tm\Adtech\Controllers\LoginController', 'login']);
             $r->addRoute('GET', '/logout', ['Tm\Adtech\Controllers\LoginController', 'logout']);

             $r->addRoute('GET', '/404', ['Tm\Adtech\Controllers\ErrorController', 'mainAction']);

             $r->addRoute('GET', '/get/{action:\w+}', ['Tm\Adtech\Controllers\AdTechEngine', 'actionDB']);
             $r->addRoute('POST', '/post/{action:\w+}', ['Tm\Adtech\Controllers\AdTechEngine', 'actionDB']);

             $r->addRoute('GET', '/ref={ref:\d+},off={off:\d+}', ['Tm\Adtech\Controllers\ReferLinkController', 'gotoReferLink']);

             $r->addRoute('GET', '/', ['Tm\Adtech\Controllers\AdTechEngine', 'checkRole']);
        
        });

        // // Fetch method and URI from somewhere
         $httpMethod = $_SERVER['REQUEST_METHOD'];
         $uri = $_SERVER['REQUEST_URI'];
        
        // // Strip query string (?foo=bar) and decode URI
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