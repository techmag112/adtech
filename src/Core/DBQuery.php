<?php

namespace Tm\Adtech\Core;

use PDO;
use Delight\Auth\Auth;
use Delight\Db\PdoDatabase;

class DBQuery {
    
    private $auth, $db;

    public function __construct(PdoDatabase $db, Auth $auth) {
        $this->db = $db;
        $this->auth = $auth;
    }

    public function getYearGrafOffers() {
        $graf = $this->db->select("select m.month, r.* from year as m left join (select i.m, sum(i.kol) as sum, format(sum(i.summa),2) as total from (SELECT MONTH(l.time) as m, sum(l.status) as kol, count(l.id)*o.price as summa FROM logs as l left join offers as o on l.offer_id = o.id AND l.status = 1 WHERE o.customer_id = ? GROUP by MONTH(l.time), o.price) as i group by i.m) as r on m.month = r.m;", [
            $this->auth->getUserId()
         ]);

        echo json_encode($graf);
    }

    public function getMonthGrafOffers() {
        $graf = $this->db->select("select m.day, r.* from month as m left join (select i.d, sum(i.kol) as sum, format(sum(i.summa),2) as total from (SELECT DAY(l.time) as d, sum(l.status) as kol, count(l.id)*o.price as summa FROM logs as l left join offers as o on l.offer_id = o.id and l.status = 1 WHERE MONTH(l.time) = MONTH(CURDATE()) AND YEAR(l.time) = YEAR(CURDATE()) AND o.customer_id = ? GROUP by DAY(l.time), o.price) as i group by i.d) as r on m.day = r.d;", [
            $this->auth->getUserId()
         ]);

        echo json_encode($graf);
    }

    public function getDayGrafOffers() {
        $graf = $this->db->select("select m.hour, r.* from day as m left join (select i.h, sum(i.kol) as sum, format(sum(i.summa),2) as total from (SELECT HOUR(l.time) as h, sum(l.status) as kol, count(l.id)*o.price as summa FROM logs as l left join offers as o on l.offer_id = o.id and l.status = 1 WHERE DAY(l.time) = DAY(CURDATE()) AND MONTH(l.time) = MONTH(CURDATE()) AND YEAR(l.time) = YEAR(CURDATE()) AND o.customer_id = ? GROUP by HOUR(l.time), o.price) as i group by i.h) as r on m.hour = r.h;", [
            $this->auth->getUserId()
         ]);

        echo json_encode($graf);
    }

    public function getYearGrafSubcr() {
        $graf = $this->db->select("select m.month, r.* from year as m left join (select i.m, sum(i.kol) as sum, format((sum(i.summa)*0.8),2) as total from (SELECT MONTH(l.time) as m, sum(l.status) as kol, count(l.id)*o.price as summa FROM logs as l left join offers as o on l.offer_id = o.id and l.status = 1 left join orders as m on m.master_id = ? and m.offer_id = o.id GROUP by MONTH(l.time), o.price) as i group by i.m) as r on m.month = r.m;", [
            $this->auth->getUserId()
         ]);

        echo json_encode($graf);
    }

    public function getMonthGrafSubcr() {
        $graf = $this->db->select("select m.day, r.* from month as m left join (select i.d, sum(i.kol) as sum, format((sum(i.summa)*0.8),2) as total from (SELECT DAY(l.time) as d, sum(l.status) as kol, count(l.id)*o.price as summa FROM logs as l left join offers as o on l.offer_id = o.id and l.status = 1 left join orders as m on m.master_id = ? and m.offer_id = o.id WHERE MONTH(l.time) = MONTH(CURDATE()) AND YEAR(l.time) = YEAR(CURDATE()) GROUP by DAY(l.time), o.price) as i group by i.d) as r on m.day = r.d;", [
            $this->auth->getUserId()
         ]);

        echo json_encode($graf);
    }

    public function getDayGrafSubcr() {
        $graf = $this->db->select("select m.hour, r.* from day as m left join (select i.h, sum(i.kol) as sum, format(sum(i.summa),2) as total from (SELECT HOUR(l.time) as h, sum(l.status) as kol, count(l.id)*o.price as summa FROM logs as l left join offers as o on l.offer_id = o.id and l.status = 1 join orders as m on m.master_id = ? and m.offer_id = o.id WHERE DAY(l.time) = DAY(CURDATE()) AND MONTH(l.time) = MONTH(CURDATE()) AND YEAR(l.time) = YEAR(CURDATE()) GROUP by HOUR(l.time), o.price) as i group by i.h) as r on m.hour = r.h;", [
            $this->auth->getUserId()
         ]);

        echo json_encode($graf);
    }

    public function getOfferList() {
        $offers = $this->db->select("SELECT a.id, a.name, a.price, a.url, a.keywords, a.status, COUNT(b.id) as count FROM offers as a left join orders AS b on a.id = b.offer_id where a.customer_id = ?  GROUP BY a.id, a.name, a.price, a.url, a.keywords, a.status;", [
                $this->auth->getUserId()
             ]);
   
        echo json_encode($offers);
    }

    public function getSubcrList() {
        $offers = $this->db->select("SELECT b.id, b.name, b.price, b.url, b.keywords, a.status FROM orders a RIGHT JOIN offers b ON ((a.offer_id = b.id AND a.master_id = ?)) WHERE b.status = 1;", [
                $this->auth->getUserId()
             ]);
   
        echo json_encode($offers);
    }

    public function setStatusOfferInDB() {
        $_POST = json_decode( file_get_contents("php://input"), true );
        $this->db->update(
            'offers',
            [
                // set
                'status' => $_POST["status"]
            ],
            [
                // where
                'id' => $_POST["id"]
            ]
        );
        if ($_POST["status"] == 0) {
            $this->db->update(
                'orders',
                [
                    // set
                    'status' => 0
                ],
                [
                    // where
                    'offer_id' => $_POST["id"]
                ]
            );
        }
    }   

    public function setStatusSubcrInDB() {
        $_POST = json_decode( file_get_contents("php://input"), true );
        if ($_POST["status"] === 1) {
            $this->db->delete(
                'orders',
                [
                    // where
                    'master_id' => $this->auth->getUserId(),
                    'offer_id' => $_POST["id"]
                ]
            );
        } else {
            $this->db->insert(
                'orders',
                [
                    // set
                    'master_id' => $this->auth->getUserId(),
                    'offer_id' => $_POST["id"],
                    'status' => 1,
                ]
            );
        } 
    }

    public function putOfferInDB() {
        $_POST = htmlspecialchars(json_decode( file_get_contents("php://input"), true ));
        $this->db->insert(
            'offers',
            [
                // set
                "customer_id" => $this->auth->getUserId(),
                "name" => $_POST["name"], 
                "price" => $_POST["price"], 
                "url" => $_POST["url"], 
                "keywords" => $_POST["keywords"]
            ]
        );
    }

}