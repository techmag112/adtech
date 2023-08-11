<?php

namespace Tm\Adtech\Controllers;

use Delight\Auth\Auth;
use League\Plates\Engine;
use Delight\Db\PdoDatabase;

use Tm\Adtech\Core\Token;
use Tm\Adtech\Core\Input;
use Tm\Adtech\Core\Redirect;

class UserDataController { 

    private $auth, $templates, $input, $token, $db, $img;

    function __construct(Engine $templates, PdoDatabase $db, Auth $auth) {
        $this->templates = $templates;
        $this->db = $db;
        $this->auth = $auth;
    }

    public function changepass_view(): void 
    {
        if (!$this->auth->isLoggedIn()) {
            Redirect::to('/login');
        } else {
           
            echo $this->templates->render('changepass');
        }
    }

    public function changepass(): void 
    {
        if (!$this->auth->isLoggedIn()) {
            Redirect::to('/login');
        } else {
            if(Input::exists()) {
                if(Token::check(Input::get('token'))) {
                    if ($_POST['new_pass'] === $_POST['new_pass_again']) {
                        try {
                            $this->auth->changePassword($_POST['current_pass'], $_POST['new_pass']);
                            Redirect::to('/', 'Пароль успешно изменен');
                        }
                        catch (\Delight\Auth\NotLoggedInException $e) {
                            $message = 'Not logged in';
                        }
                        catch (\Delight\Auth\InvalidPasswordException $e) {
                            $message = 'Invalid password(s)';
                        }
                        catch (\Delight\Auth\TooManyRequestsException $e) {
                            $message = 'Too many requests';
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

    public function update_view(): void 
    {
        if (!$this->auth->isLoggedIn()) {
            Redirect::to('/login');
        } else {
            echo $this->templates->render('update', [
                'username' => $this->auth->getUsername(),''  
            ]);
        }
    }

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