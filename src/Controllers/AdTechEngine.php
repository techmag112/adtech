<?php

namespace Tm\Adtech\Controllers;

use Delight\Auth\Auth;
use League\Plates\Engine;
use Delight\Db\PdoDatabase;

use Tm\Adtech\Core\Redirect;
use Tm\Adtech\Core\DBQuery;

class AdTechEngine {

    private $auth, $templates, $session_name, $input, $token, $db;

    function __construct(Engine $templates, Auth $auth, DBQuery $db) {
        $this->templates = $templates;
        $this->auth = $auth;
        $this->db = $db;
    }

    public function checkRole(): void 
    {

        if ($this->auth->isLoggedIn()) {

            if ($this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
                echo $this->templates->render('admin');
            } elseif ($this->auth->hasRole(\Delight\Auth\Role::PUBLISHER)) {
                echo $this->templates->render('publisher');
            } elseif ($this->auth->hasRole(\Delight\Auth\Role::SUBSCRIBER)) {
                echo $this->templates->render('subscriber');
            } else {
                echo $this->templates->render('wait');
            }
        } else {
            Redirect::to('/login');
        }

    }

    public function actionDB($arg) {
        call_user_func([$this->db, $arg['action']]);
    }


}