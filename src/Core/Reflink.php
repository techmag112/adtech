<?php

namespace Tm\Adtech\Core;

use PDO;
use Delight\Db\PdoDatabase;

/**
 * Класс содержит все методы работы и учета с реферальными линками
 */
class Reflink {

    /**
    * @var object $db - экземпляр класса Delight\Db\PdoDatabase (Доступ к базе данных)
    */
    private $db;

    public function __construct(PdoDatabase $db) {
        $this->db = $db;
    }

    /**
    * checkRefLink() возвращает id заказчика и урл реферальной ссылки, если оффер активен
    *
    * @param int $offer_id - id рекламного предложения
    * @return Array
    */
    public function checkRefLink($offer_id) {
        return $this->db->select("select customer_id, url FROM offers WHERE status = 1 AND id = ?;", [
                $offer_id 
             ]);
    }

    /**
    * addLogs() добавляет строку лога о переходе на рекламную ссылку в таблицу Logs 
    *
    * @param int $master_id - id веб мастера
    * @param int $offer_id - id рекламного предложения
    * @param int $status - статус успешности перехода по ссылке: 1 - да, 0 - нет
    * @return void
    */
    public function addLogs($master_id, $offer_id, $status) {
        d($master_id, $offer_id, $status);
        die;
        $this->db->insert(
            'logs',
            [
                // set
                "master_id" => $master_id,
                "customer_id" => $this->url['customer_id'], 
                "offer_id" => $offer_id, 
                "url" => $this->url['url'], 
                "status" => $status
            ]
        );
    }
    
}