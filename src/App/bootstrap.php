<?php

namespace Tm\Adtech\App;

use \Tm\Adtech\Core\Router;

// Start a Session
if( !session_id() ) {
    session_start();
}

Router::run();
