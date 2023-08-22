<?php

namespace Tm\Adtech\Core;

use PDO;
use Delight\Auth\Auth;
use Delight\Db\PdoDatabase;
use Tm\Adtech\Core\Token;

/**
 * Класс содержит все методы-запросы к базе для внешнего интерфейса
 */
class DBQuery {
    
    /**
    * @var object $auth - экземпляр класса Delight\Auth\Auth (Авторизация)
    * @var object $db - экземпляр класса Delight\Db\PdoDatabase (Доступ к базе данных)
    */
    private $auth, $db;

    /**
    * Метод конструктор класса
    * В нем идет присвоение локальным переменным экземпляров классов из контейнера зависимостей (DI)
    */
    public function __construct(PdoDatabase $db, Auth $auth) {
        $this->db = $db;
        $this->auth = $auth;
    }

    /**
    * countLinksYear() возвращает количество выданных ссылок и количество отказов в переходах за последний год
    * @return string json
    */
    public function countLinksAndRejectYear() {
        $value[0] = $this->db->selectValue(
            'SELECT count(master_id) FROM links WHERE YEAR(time) = YEAR(CURDATE());'
        );
        $value[1] = $this->db->selectValue(
            'SELECT count(status) FROM logs WHERE YEAR(time) = YEAR(CURDATE()) AND status = 0;'
        );
        echo json_encode($value);
    }

    /**
    * countLinksMonth() возвращает количество выданных ссылок и количество отказов в переходах за последний месяц
    * @return string json
    */
    public function countLinksAndRejectMonth() {
        $value[0] = $this->db->selectValue(
            'SELECT count(master_id) FROM links WHERE MONTH(time) = MONTH(CURDATE()) AND YEAR(time) = YEAR(CURDATE());'
        );
        $value[1] = $this->db->selectValue(
            'SELECT count(status) FROM logs WHERE MONTH(time) = MONTH(CURDATE()) AND YEAR(time) = YEAR(CURDATE()) AND status = 0;'
        );
        echo json_encode($value);
    }

    /**
    * countLinksDay() возвращает количество выданных ссылок и количество отказов в переходах за последний день
    * @return string json
    */
    public function countLinksAndRejectDay() {
        $value[0] = $this->db->selectValue(
            'SELECT count(master_id) FROM links WHERE DAY(time) = DAY(CURDATE()) AND MONTH(time) = MONTH(CURDATE()) AND YEAR(time) = YEAR(CURDATE());'
        );
        $value[1] = $this->db->selectValue(
            'SELECT count(status) FROM logs WHERE DAY(time) = DAY(CURDATE()) AND MONTH(time) = MONTH(CURDATE()) AND YEAR(time) = YEAR(CURDATE()) AND status = 0;'
        );
        echo json_encode($value);
    }

    /**
    * addEventLink() добавляет в таблицу links информацию о выданной ссылке
    * @param string json (offer_id - id рекламного предложения-ссылки)
    */
    public function addEventLink() {
        $_POST = json_decode( file_get_contents("php://input"), true );
        $this->db->insert(
           'links',
                [
                    // set
                    'master_id' => $this->auth->getUserId(),
                    'offer_id' => $_POST["id"]
                ]
            );
    }

    /**
    * getMonthGrafAdmin() возвращает число переходов по ссылкам и доход в разрезе последнего месяца для администратора
    * @return string json
    */
    public function getMonthGrafAdmin() {
        $graf = $this->db->select("select m.day, r.* from month as m left join (select i.d, sum(i.kol) as sum, format((sum(i.summa)*0.2),2) as total from (SELECT DAY(l.time) as d, sum(l.status) as kol, count(l.id)*o.price as summa FROM logs as l left join offers as o on l.offer_id = o.id and l.status = 1 left join orders as m on m.offer_id = o.id WHERE MONTH(l.time) = MONTH(CURDATE()) AND YEAR(l.time) = YEAR(CURDATE()) GROUP by DAY(l.time), o.price) as i group by i.d) as r on m.day = r.d;");

        echo json_encode($graf);
    }

    /**
    * getDayGrafAdmin() возвращает число переходов по ссылкам и доход в разрезе последнего дня для администратора
    * @return string json
    */
    public function getDayGrafAdmin() {
        $graf = $this->db->select("select m.hour, r.* from day as m left join (select i.h, sum(i.kol) as sum, format((sum(i.summa)*0.2),2) as total from (SELECT HOUR(l.time) as h, sum(l.status) as kol, count(l.id)*o.price as summa FROM logs as l left join offers as o on l.offer_id = o.id and l.status = 1 join orders as m on m.offer_id = o.id WHERE DAY(l.time) = DAY(CURDATE()) AND MONTH(l.time) = MONTH(CURDATE()) AND YEAR(l.time) = YEAR(CURDATE()) GROUP by HOUR(l.time), o.price) as i group by i.h) as r on m.hour = r.h;");

        echo json_encode($graf);
    }

    /**
    * getMonthGrafAdmin() возвращает число переходов по ссылкам и доход в разрезе последнего года для администратора
    * @return string json
    */
    public function getYearGrafAdmin() {
        $graf = $this->db->select("select m.month, r.* from year as m left join (select i.m, sum(i.kol) as sum, format((sum(i.summa)*0.2),2) as total from (SELECT MONTH(l.time) as m, sum(l.status) as kol, count(l.id)*o.price as summa FROM logs as l left join offers as o on l.offer_id = o.id and l.status = 1 left join orders as m on m.offer_id = o.id GROUP by MONTH(l.time), o.price) as i group by i.m) as r on m.month = r.m;");

        echo json_encode($graf);
    }

    /**
    * setRoleInDB() установить роль пользователя (0 - нет роли, 1 - администратор, 163856 - заказчики, 131090 - веб-мастера)
    * @param string json (id - id пользователя)
    */
    public function setRoleInDB() {
	$_POST = json_decode( file_get_contents("php://input"), true );
        $this->db->update(
            'users',
            [
                // set
                'roles_mask' => $_POST["roles_mask"]
            ],
            [
                // where
                'id' => $_POST["id"]
            ]
        );
    }

    /**
    * getUserList() возвращает список пользователей системы, кроме администратора
    * @return string json
    */
    public function getUserList() {
	 $users = $this->db->select("SELECT id, email, username, roles_mask FROM users WHERE id <> ?;", [
            $this->auth->getUserId()
         ]);

        echo json_encode($users);
   }

    /**
    * getCurrentOrder() возвращает список id выбранного заказа веб-мастера
    * @return string json
    */
    public function getCurrentOrder() {
	 $_POST = json_decode( file_get_contents("php://input"), true );
	 $order = $this->db->select("SELECT id, master_id, offer_id FROM orders WHERE offer_id = ? AND master_id = ?;", [
	            $_POST['offer_id'], 
                $this->auth->getUserId()
             ]);
   
        echo json_encode($order);
    }

    /**
    * getYearGrafOffer() возвращает число переходов по ссылкам и доход в разрезе последнего года по id заказчика
    * @return string json
    */
    public function getYearGrafOffers() {
        $graf = $this->db->select("select m.month, r.* from year as m left join (select i.m, sum(i.kol) as sum, format(sum(i.summa),2) as total from (SELECT MONTH(l.time) as m, sum(l.status) as kol, count(l.id)*o.price as summa FROM logs as l left join offers as o on l.offer_id = o.id AND l.status = 1 WHERE o.customer_id = ? GROUP by MONTH(l.time), o.price) as i group by i.m) as r on m.month = r.m;", [
            $this->auth->getUserId()
         ]);

        echo json_encode($graf);
    }

    /**
    * getMonthGrafOffer() возвращает число переходов по ссылкам и доход в разрезе последнего месяца по id заказчика
    * @return string json
    */
    public function getMonthGrafOffers() {
        $graf = $this->db->select("select m.day, r.* from month as m left join (select i.d, sum(i.kol) as sum, format(sum(i.summa),2) as total from (SELECT DAY(l.time) as d, sum(l.status) as kol, count(l.id)*o.price as summa FROM logs as l left join offers as o on l.offer_id = o.id and l.status = 1 WHERE MONTH(l.time) = MONTH(CURDATE()) AND YEAR(l.time) = YEAR(CURDATE()) AND o.customer_id = ? GROUP by DAY(l.time), o.price) as i group by i.d) as r on m.day = r.d;", [
            $this->auth->getUserId()
         ]);

        echo json_encode($graf);
    }

    /**
    * getDayGrafOffer() возвращает число переходов по ссылкам и доход в разрезе последнего дня по id заказчика
    * @return string json
    */
    public function getDayGrafOffers() {
        $graf = $this->db->select("select m.hour, r.* from day as m left join (select i.h, sum(i.kol) as sum, format(sum(i.summa),2) as total from (SELECT HOUR(l.time) as h, sum(l.status) as kol, count(l.id)*o.price as summa FROM logs as l left join offers as o on l.offer_id = o.id and l.status = 1 WHERE DAY(l.time) = DAY(CURDATE()) AND MONTH(l.time) = MONTH(CURDATE()) AND YEAR(l.time) = YEAR(CURDATE()) AND o.customer_id = ? GROUP by HOUR(l.time), o.price) as i group by i.h) as r on m.hour = r.h;", [
            $this->auth->getUserId()
         ]);

        echo json_encode($graf);
    }

    /**
    * getYearGrafSubcr() возвращает число переходов по ссылкам и доход в разрезе последнего года по id веб-мастера
    * @return string json
    */
    public function getYearGrafSubcr() {
        $graf = $this->db->select("select m.month, r.* from year as m left join (select i.m, sum(i.kol) as sum, format((sum(i.summa)*0.8),2) as total from (SELECT MONTH(l.time) as m, sum(l.status) as kol, count(l.id)*o.price as summa FROM logs as l left join offers as o on l.offer_id = o.id and l.status = 1 left join orders as m on m.master_id = ? and m.offer_id = o.id GROUP by MONTH(l.time), o.price) as i group by i.m) as r on m.month = r.m;", [
            $this->auth->getUserId()
         ]);

        echo json_encode($graf);
    }

     /**
    * getMonthGrafSubcr() возвращает число переходов по ссылкам и доход в разрезе последнего месяца по id веб-мастера
    * @return string json
    */
    public function getMonthGrafSubcr() {
        $graf = $this->db->select("select m.day, r.* from month as m left join (select i.d, sum(i.kol) as sum, format((sum(i.summa)*0.8),2) as total from (SELECT DAY(l.time) as d, sum(l.status) as kol, count(l.id)*o.price as summa FROM logs as l left join offers as o on l.offer_id = o.id and l.status = 1 left join orders as m on m.master_id = ? and m.offer_id = o.id WHERE MONTH(l.time) = MONTH(CURDATE()) AND YEAR(l.time) = YEAR(CURDATE()) GROUP by DAY(l.time), o.price) as i group by i.d) as r on m.day = r.d;", [
            $this->auth->getUserId()
         ]);

        echo json_encode($graf);
    }

     /**
    * getDayGrafSubcr() возвращает число переходов по ссылкам и доход в разрезе последнего дня по id веб-мастера
    * @return string json
    */
    public function getDayGrafSubcr() {
        $graf = $this->db->select("select m.hour, r.* from day as m left join (select i.h, sum(i.kol) as sum, format(sum(i.summa),2) as total from (SELECT HOUR(l.time) as h, sum(l.status) as kol, count(l.id)*o.price as summa FROM logs as l left join offers as o on l.offer_id = o.id and l.status = 1 join orders as m on m.master_id = ? and m.offer_id = o.id WHERE DAY(l.time) = DAY(CURDATE()) AND MONTH(l.time) = MONTH(CURDATE()) AND YEAR(l.time) = YEAR(CURDATE()) GROUP by HOUR(l.time), o.price) as i group by i.h) as r on m.hour = r.h;", [
            $this->auth->getUserId()
         ]);

        echo json_encode($graf);
    }

    /**
    * getOfferList() возвращает список офферов по id заказчика
    * @return string json
    */
    public function getOfferList() {
        $offers = $this->db->select("SELECT a.id, a.name, a.price, a.url, a.keywords, a.status, COUNT(b.id) as count FROM offers as a left join orders AS b on a.id = b.offer_id where a.customer_id = ?  GROUP BY a.id, a.name, a.price, a.url, a.keywords, a.status;", [
                $this->auth->getUserId()
             ]);
   
        echo json_encode($offers);
    }

    /**
    * getSubcrList() возвращает список офферов по id заказчика
    * @return string json
    */
    public function getSubcrList() {
        $offers = $this->db->select("SELECT b.id, b.name, b.price, b.url, b.keywords, a.status FROM orders a RIGHT JOIN offers b ON ((a.offer_id = b.id AND a.master_id = ?)) WHERE b.status = 1;", [
                $this->auth->getUserId()
             ]);
   
        echo json_encode($offers);
    }

    /**
    * setStatusOfferInDB() изменяет статус оффера (активный-деактивированный) по id оффера
    * @param string json
    */
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
    }   

    /**
    * setStatusSubcrInDB() изменяет статус заказа веб-мастера (активный-деактивированный) по id оффера
    * @param string json
    */
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

     /**
    * putOfferInDB() добавить новый оффер по id заказчика (customer_id)
    * @param string json
    */
    public function putOfferInDB() {
        $_POST = json_decode( file_get_contents("php://input"), true );
        if(Token::check($_POST["CSRF-token"])) {
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
        } else {
            return false;
        }
    }

}