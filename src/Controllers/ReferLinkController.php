<?php

namespace Tm\Adtech\Controllers;

use Tm\Adtech\Core\Reflink;

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
        ['ref' => $id_master, 'off' => $id_offer] = $vars;
 
        $url = $this->ref->checkRefLink($id_offer);
        if (!empty($url)) {
            // пошли куда послали
            $this->ref->addLogs($id_master, $id_offer, 1);
        } else {
            // пошли на 404
            $this->ref->addLogs($id_master, $id_offer, 0);
            Redirect::to('404');
        }
    }

}