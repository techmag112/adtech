<?php

namespace Tm\Adtech\Core;

use PDO;
use Delight\Db\PdoDatabase;

class Reflink {

    private $auth, $db;

    public function __construct(PdoDatabase $db) {
        $this->db = $db;
    }

    public function checkRefLink($id_master, $id_offer) {
        $url = $this->db->select("select customer_id, url FROM offers WHERE status = 1 AND id = ?;", [
                $id_offer 
             ]);
        if (empty($url)) {
            $this->db->insert(
                'logs',
                [
                    // set
                    "master_id" => $master_id,
                    "customer_id" => $url["customer_id"], 
                    "offer_id" => $offer_id, 
                    "url" => $url["url"], 
                    "status" => 0
                ]
            );
            return false;
        } else {
            $this->db->insert(
                'logs',
                [
                    // set
                    "master_id" => $master_id,
                    "customer_id" => $url["customer_id"], 
                    "offer_id" => $offer_id, 
                    "url" => $url["url"], 
                    "status" => 1
                ]
            );
            return true;
        }
    }
    
}