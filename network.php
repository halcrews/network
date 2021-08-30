<?php
require ('config_db.php');
$connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if ($connect == false){
    print("Ошибка: Невозможно подключиться к базе". mysqli_connect_error());
}
else {

    $result = mysqli_query($connect, "SELECT * FROM `pc` INNER JOIN `domains` ON `pc`.`domain_name` = `domains`.`domain_name`") or die(mysqli_error());

    while($row = mysqli_fetch_object($result)) {
        $arr[] = $row;
    }

    $json_response = json_encode($arr);

    echo $json_response;

    $connect->close();
}
?>