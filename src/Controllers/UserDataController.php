<?php

namespace Tm\Adtech\Controllers;

use Delight\Auth\Auth;
use League\Plates\Engine;
use Delight\Db\PdoDatabase;

use Tm\Adtech\Core\Token;
use Tm\Adtech\Core\Input;
use Tm\Adtech\Core\Redirect;

/**
* Класс контроллера редактирования данных пользователя
*/
class UserDataController { 

    private $auth, $templates, $db;

    function __construct(Engine $templates, PdoDatabase $db, Auth $auth) {
        $this->templates = $templates;
        $this->db = $db;
        $this->auth = $auth;
    }

    /**
    * changepass_view() вывод шаблона изменения пароля авторизированного пользователя
    * @return void
    */
    public function changepass_view(): void 
    {
        if (!$this->auth->isLoggedIn()) {
            Redirect::to('/login');
        } else {
           
            echo $this->templates->render('changepass');
        }
    }

    /**
    * changepass() сохранение в базе измененного пароля с проверкой токена формы (защита от XSS)
    * @return void
    */
    public function changepass(): void 
    {
        /** Пользователь не зарегестрирован? */
        if (!$this->auth->isLoggedIn()) {
            Redirect::to('/login');
        } else {
            /** Проверка полей и токена формы на корректность */
            if(Input::exists()) { 
                if (Token::check(Input::get('token'))) {
                    if ($_POST['new_pass'] === $_POST['new_pass_again']) {
                        try {
                            $this->auth->changePassword($_POST['current_pass'], $_POST['new_pass']);
                            Redirect::to('/', 'Пароль успешно изменен');
                        }
                        catch (\Delight\Auth\InvalidPasswordException $e) {
                            $message = 'Неверный пароль';
                        }
                        catch (\Delight\Auth\TooManyRequestsException $e) {
                            $message = 'Слишком много запросов';
                        }
                    } else {
                        $message = 'Варианты нового пароля не совпадают.';    
                    }
                } else {
                    $message = 'Токен формы не прошел проверку';
                }
            } else {
                $message = 'Не заполнены поля формы';
            }

            echo $this->templates->render('changepass', [
                'message' => $message,
                'type' => 'error'
            ]);

        }
    }

     /**
    * update_view() вывод шаблона изменения имени авторизированного пользователя
    * @return void
    */
    public function update_view(): void 
    {
        /** Пользователь не авторизован? */
        if (!$this->auth->isLoggedIn()) {
            Redirect::to('/login');
        } else {
            echo $this->templates->render('update', [
                'username' => $this->auth->getUsername(),''  
            ]);
        }
    }

     /**
    * update() обновление в базе имени авторизированного пользователя  с проверкой токена формы (защита от XSS)
    * @return void
    */
    public function update(): void 
    {
        if (!$this->auth->isLoggedIn()) {
            Redirect::to('/login');
        } else {
            if(Input::exists()) {
                if(Token::check(Input::get('token'))) {
                        $username = $_POST['username'];
                        if ($this->auth->getUsername() !=  $username) {
                                $this->db->exec(
                                    "UPDATE users SET username = ? WHERE id = ?",
                                    [
                                        $username,
                                        $this->auth->getUserId()
                                    ]
                                );
                                Redirect::to('/', 'Изменение успешно принято.');
                        } else {
                            $message = 'Данное имя пользователя уже существует';
                        }
                } else {
                    $message = 'Токен формы не прошел проверку';
                }
            } else {
                $message = 'Не заполнены поля ввода';
            }
            echo $this->templates->render('update', [
                'username' => $this->auth->getUsername(),
                '',
                'message' => $message,
                'type' => 'error'
            ]);
        }
    }
    

}