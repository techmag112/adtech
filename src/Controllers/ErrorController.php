<?php

namespace Tm\Adtech\Controllers;

use League\Plates\Engine;

class ErrorController {

    private $templates;

    function __construct(Engine $templates) {
        $this->templates = $templates;
     }

    public function mainAction() {
        echo $this->templates->render('404');   
          
    }
}