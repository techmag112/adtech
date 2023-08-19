<?php

namespace Tm\Adtech\Controllers;

use Tm\Adtech\Core\Reflink;
use Tm\Adtech\Core\Redirect;

/**
* Класс контроллера обработки и выдачи реферальной ссылки
*/
class ReferLinkController {

    /**
    * @var object $ref - экземпляр класса Reflink
    */
    private $ref;

    function __construct(Reflink $ref) {
        $this->ref = $ref;
    }

    /**
    * gotoReferLink добавляет строку лога о переходе на рекламную ссылку в таблицу Logs 
    * @param array $vars - массив переменных с роутера ($id_master, $id_offer)
    */
    function gotoReferLink($vars) {
        // Деконструкция массива переменных
        ['ref' => $master_id, 'off' => $offer_id] = $vars;
 
        $link = $this->ref->checkRefLink($master_id, $offer_id);
       
        if (!empty($link)) {
            // пошли куда послали
            $this->ref->addLogs($master_id, $link[0]['customer_id'], $offer_id, 1);
            Redirect::to('http://' . $link[0]['url']);
        } else {
            // пошли на 404
            $this->ref->addLogs($master_id, 0, $offer_id, 0);
            Redirect::to('404');
        }
    }

}