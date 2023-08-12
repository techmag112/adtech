<?php

namespace Tm\Adtech\Core;

use PDO;
use Delight\Auth\Auth;
use Delight\Db\PdoDatabase;
use Tm\Adtech\Core\Redirect;

class Reflink {

    private $auth, $db;

    public function __construct(PdoDatabase $db, Auth $auth) {
        $this->db = $db;
        $this->auth = $auth;
    }

    public function checkRefLink() {
        return true;
    }
    
}