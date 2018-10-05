<?php

/**
 * 数据库配置
 *
 * @author: xieyong <qxieyongp@163.com>
 * @Date: 2017/8/20
 * @Time: 16:00
 */

$config = require(CONFIG_PATH . '/config.php');

return [
    'default_db' => [
        'database_type' => $config['db.database_type'],
        'database_name' => $config['db.database_name'],
        'ip' => $config['db.ip'],
        'port' => $config['db.port'],
        'username' => $config['db.username'],
        'password' => $config['db.password'],
        'charset' => $config['db.charset'],
        'prefix' => $config['db.prefix'],
        'persistent' => $config['db.persistent'],
    ],
];
