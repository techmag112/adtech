<?php

namespace Tm\Adtech\Controllers;

use Tm\Adtech\Core\Reflink;

class ReferLinkController {

    function gotoReferLink($vars) {
        // Деконструкция массива переменных
        ['ref' => $id_master, 'off' => $id_offer] = $vars;
 
        if (checkRefLink($id_master, $id_offer)) {
            // пошли куда послали
            d($id_master, $id_offer);
            die;
        } else {
            // пошли на 404
            Redirect::to('404');
        }
    }

}