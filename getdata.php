<?php
require ('config_db.php');

$jsondata = file_get_contents('php://input');//Принимаем json с машины
$data = json_decode($jsondata, true);

$connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if ($connect == false){
    print("Ошибка: Невозможно подключиться к базе". mysqli_connect_error());
}
else {
    $query = "CREATE TABLE IF NOT EXISTS `domains` (
`id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`domain_name` TEXT,
UNIQUE KEY `domain_name` (`domain_name`)
);";

    $query .= "CREATE TABLE IF NOT EXISTS `pc` (
`id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`pc_id` TEXT,
`net_architect` TEXT,
`os_version` TEXT,
`domain_name` TEXT,
`pc_role` TEXT,
`user_name` TEXT,
`pc_name` TEXT,
`ram` TEXT,
`proc` TEXT,
`os_language` TEXT,
`proccesses_list` TEXT,
`servicies_list` TEXT,
`disks` TEXT,
`net_topology` TEXT,
`bin_list` TEXT,
UNIQUE KEY `pc_id` (`pc_id`,`domain_name`)
);";


    if (!$connect->multi_query($query)) {
        echo "Не удалось выполнить мультизапрос: (" . $mysqli->errno . ") " . $mysqli->error;
    }

    do {
        if ($res = $connect->store_result()) {
            var_dump($res->fetch_all(MYSQLI_ASSOC));
            echo var_dump($res->fetch_all(MYSQLI_ASSOC));
            $res->free();
        }
    } while ($connect->more_results() && $connect->next_result());

//Заполняем таблицы данными файла из пришедшего json’а

    if (isset($data['network_data'])) {
        $array_length = count($data[network_data]);
        for ($i = 0; $i < $array_length; ++$i) {
            $sql = "INSERT IGNORE INTO domains (domain_name) VALUES ('".base64_decode($data['network_data'][$i]['domain_name'])."');";
            $connect->query($sql);
        }
    }

    if (isset($data['network_data'])) {
        $array_length = count($data[network_data]);
        for ($i = 0; $i < $array_length; ++$i) {
            $sql = "INSERT IGNORE INTO pc (pc_id, net_architect, os_version, domain_name, pc_role, user_name, pc_name, ram, proc, os_language, proccesses_list, servicies_list, disks, net_topology, bin_list) VALUES ('".base64_decode($data['network_data'][$i]['pc_id'])."', '".base64_decode($data['network_data'][$i]['net_architect'])."', '".base64_decode($data['network_data'][$i]['os_version'])."', '".base64_decode($data['network_data'][$i]['domain_name'])."', '".base64_decode($data['network_data'][$i]['pc_role'])."', '".base64_decode($data['network_data'][$i]['user_name'])."', '".base64_decode($data['network_data'][$i]['pc_name'])."', '".base64_decode($data['network_data'][$i]['ram'])."', '".base64_decode($data['network_data'][$i]['proc'])."', '".base64_decode($data['network_data'][$i]['os_language'])."', '".base64_decode($data['network_data'][$i]['proccesses_list'])."', '".base64_decode($data['network_data'][$i]['servicies_list'])."', '".base64_decode($data['network_data'][$i]['disks'])."', '".base64_decode($data['network_data'][$i]['net_topology'])."', '".base64_decode($data['network_data'][$i]['bin_list'])."') ON DUPLICATE KEY UPDATE net_architect = values(net_architect), os_version = values(os_version), pc_role = values(pc_role), user_name = values(user_name), pc_name = values(pc_name), ram = values(ram), proc = values(proc), os_language = values(os_language), proccesses_list = values(proccesses_list), servicies_list = values(servicies_list), disks = values(disks), net_topology = values(net_topology), bin_list = values(bin_list);";;
            $connect->query($sql);
        }
    }

    $connect->close();

}