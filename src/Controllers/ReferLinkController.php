<?php

namespace Tm\Adtech\Controllers;

use Tm\Adtech\Core\Reflink;

class ReferLinkController {

    private $ref;

    function __construct(Reflink $ref) {
        $this->ref = $ref;
    }

    function gotoReferLink($vars) {
        // Деконструкция массива переменных
        ['ref' => $id_master, 'off' => $id_offer] = $vars;
 
        if ($this->ref->checkRefLink($id_master, $id_offer)) {
            // пошли куда послали
            d($id_master, $id_offer);
            die;
        } else {
            // пошли на 404
            Redirect::to('404');
        }
    }

}