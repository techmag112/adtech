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
    * @param int $master_id - id веб-мастер
    * @param int $offer_id - id рекламного предложения
    * @return Array
    */
    public function checkRefLink($master_id, $offer_id) {
        return $this->db->select("SELECT customer_id, url FROM offers INNER JOIN orders ON offers.id = orders.offer_id AND orders.master_id = ? AND offers.id = ? AND offers.status = 1;", [
                $master_id,
                $offer_id 
             ]);
    }

    /**
    * addLogs() добавляет строку лога о переходе на рекламную ссылку в таблицу Logs 
    *
    * @param int $master_id - id веб мастера
    * @param int $customer_id - id заказчика
    * @param int $offer_id - id рекламного предложения
    * @param int $status - статус успешности перехода по ссылке: 1 - да, 0 - нет
    * @return void
    */
    public function addLogs($master_id, $customer_id, $offer_id, $status) {
        $this->db->insert(
            'logs',
            [
                // set
                "master_id" => $master_id,
                "customer_id" => $customer_id, 
                "offer_id" => $offer_id, 
                "status" => $status
            ]
        );
    }
    
}