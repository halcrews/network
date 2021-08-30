# Визуализация топологии сети

1. Файл getdata.php принимает данные с машин методом post в виде json-файла и 
заносит их, декодируя из base64, в базу network.

1.1. Пример json-файла:

{
    "network_data": [{
        "pc_id": "UEMy",
        "net_architect": "U3Rhci1CdXM=",
        "os_version": "V2luZG93czc=",
        "domain_name": "RG9tYWluLTE=",
        "pc_role": "TG9jYWwgVXNlcg==",
        "user_name": "VXNlcjI=",
        "pc_name": "UEMtVXNlcjI=",
        "ram": "MzJHYg==",
        "proc": "SW50ZWwgQ29yZSBpNS0xMTUwMEhF",
        "os_language": "RW5nbGlzaA==",
        "proccesses_list": "d3NhcHB4LCBSZWdpc3RyeSwgU3lzdGVt",
        "servicies_list": "Y2JkaHN2YywgQ3NjU2VydmljZSwgZGVmcmFnc3Zj",
        "disks": "QyAoMTA2NEdiKSwgRCAoOTMxR2Ip",
        "net_topology": "MTkyLjE2OC4wLjM3",
        "bin_list": "d2FiLmV4ZSwgd29yZHBhZC5leGU="
    }]
}

2. Файл network.php производит обратную процедуру - т.е. достаёт данные из базы
и формирует из них json-файл, который используется для визуализации сети.

3. Файл index.php выводит данные в виде графика. Для построения графика 
использовалась библиотека Google OrgChart. Данные сети выводятся в виде организационной 
структуры - доменов и входящих в них машин.

4. Инофрмация о каждом из устройств, входящих в тот или иной домен, может быть 
получена путём наведения курсора на графическое изображение этого устройства.
