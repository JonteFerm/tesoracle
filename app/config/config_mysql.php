<?php

return [
    'dsn'     => "mysql:host=127.0.0.1;dbname=test;",
    'username'        => "root",
    'password'        => "",
    'driver_options'  => [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
    'table_prefix'    => "",
    'verbose' => false,
    //'debug_connect' => 'true',
];

/*return [
    'dsn'     => "mysql:host=blu-ray.student.bth.se;dbname=jofe14;",
    'username'        => "jofe14",
    'password'        => "Fc%*4Iu#",
    'driver_options'  => [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
    'table_prefix'    => "",
    'verbose' => false,
    //'debug_connect' => 'true',
];*/)
