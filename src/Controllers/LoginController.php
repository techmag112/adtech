<?php

namespace Tm\Adtech\Controllers;

use Delight\Auth\Auth;
use League\Plates\Engine;

use Tm\Adtech\Core\Token;
use Tm\Adtech\Core\Input;
use Tm\Adtech\Core\Redirect;
use Tm\Adtech\Core\Session;

class LoginController {

    private $auth, $templates, $input, $token;

    function __construct(Engine $templates, Auth $auth) {
        $this->templates = $templates;
        $this->auth = $auth;
    }

    public function login_form_view(): void 
    {
        if (!$this->auth->isLoggedIn()) {
            echo $this->templates->render('login');
        } else {
            Redirect::to('/');
        }
    }

    public function reg_form_view(): void 
    {
        if (!$this->auth->isLoggedIn()) {
            echo $this->templates->render('register');
        } else {
            Redirect::to('/');
        }
    }

    public function logout(): void {
        $this->auth->logOut();
        $this->auth->destroySession();
        Redirect::to('/login');
    }

    public function login(): void
    {
        if (!$this->auth->isLoggedIn()) {
            try {
                if(Input::exists() && Token::check(Input::get('token'))) {
                        $this->auth->login($_POST['email'], $_POST['password']);
                        //User is logged in ??????
                        Redirect::to('/');
                } else {
                    echo $this->templates->render('login', [
                        'message' => 'Ошибка токена',
                        'type' => 'error'
                    ]);
                }
            }
            catch (\Delight\Auth\InvalidEmailException $e) {
                echo $this->templates->render('login', [
                    'message' => 'Неверный емаил адрес',
                    'type' => 'error'
                ]);
            }
            catch (\Delight\Auth\InvalidPasswordException $e) {
                echo $this->templates->render('login', [
                    'message' => 'Неверный пароль',
                    'type' => 'error'
                ]);
            }
            catch (\Delight\Auth\TooManyRequestsException $e) {
                echo $this->templates->render('login', [
                    'message' => 'Слишком много запросов',
                    'type' => 'error'
                ]);
            }
        }
    }
  
    public function isRegistration(): void 
    {
            try {
                    if($_POST['password'] === $_POST['password_again']) {
                            $username = (($_POST['username'] == '') ? 'User' . mb_substr(uniqid(), 4, 4) : $_POST['username']);
                            $userId = $this->auth->registerWithUniqueUsername($_POST['email'], $_POST['password'], $username);           
                            Redirect::to('/login', 'Вы успешно зарегестрированы.');
                    } else {
                            echo $this->templates->render('register', [
                                'message' => 'Неверный пароль',
                                'type' => 'error'
                            ]);
                    }            
            }
            catch (\Delight\Auth\DuplicateUsernameException $e) {
                echo $this->templates->render('register', [
                    'message' => 'Данное имя пользователя уже используется.',
                    'type' => 'error'
                ]);
            }
            catch (\Delight\Auth\InvalidEmailException $e) {
                echo $this->templates->render('register', [
                    'message' => 'Неверный емаил',
                    'type' => 'error'
                ]);
            }
            catch (\Delight\Auth\InvalidPasswordException $e) {
                echo $this->templates->render('register', [
                    'message' => 'Неверный пароль',
                    'type' => 'error'
                ]);
            }
            catch (\Delight\Auth\UserAlreadyExistsException $e) {
                echo $this->templates->render('register', [
                    'message' => 'Пользователь уже существует',
                    'type' => 'error'
                ]);
            }
            catch (\Delight\Auth\TooManyRequestsException $e) {
                echo $this->templates->render('register', [
                    'message' => 'Слишком много запросов',
                    'type' => 'error'
                ]);
            }
    }

}