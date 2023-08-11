<?php

//$auth->admin()->addRoleForUserById(1, \Delight\Auth\Role::ADMIN);

require_once 'vendor/autoload.php';
use PDO;
use Delight\Db\PdoDatabase;

// use the factory to create a Faker\Generator instance
$faker = Faker\Factory::create();
// generate data by calling methods
//echo $faker->name();
// 'Vince Sporer'
//echo $faker->email();
// 'walter.sophia@hotmail.com'
//echo $faker->text();

$driver = "mysql";
$host = "localhost";
$port = 3400;
$database_name = "adtech";
$username = "root";
$password = "";
$mypdo = new PDO("$driver:host=$host:$port;dbname=$database_name", $username, $password);
$db = \Delight\Db\PdoDatabase::fromPdo($mypdo);
for ($i=0; $i <=15; $i++) {
        echo "add " . $i+1 . PHP_EOL;
        $db->insert(
            'users',
            [
                // set
                "email" => $faker->email(),
                "password" => '$2y$10$OUYoazgFxR6GQwUomN9Cqeq5gF8h.sQ5I6c7cJxXq.aj5uYiqqRRS',
                "username" => $faker->name(), 
                "status" => 0, 
                "verified" => 1, 
                "ressetable" => 1,
                "roles_mask" => 0,
                "registered" => 1690891278,
                "last_login" => null,
                "force_logout" => 0
            ]
        );
}
