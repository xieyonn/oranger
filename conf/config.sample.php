<?php

/**
 * config sample
 */

return [
    'db.database_type' => 'mysql',
    'db.ip' => '127.0.0.1',  // ip地址
    'db.port' => 0,          // 端口号
    'db.username' => '',        // 用户名
    'db.password' => '',      // 密码
    'db.database_name' => 'dbname',
    'db.charset' => 'utf8',        // 字符集
    'db.prefix' => '',            // 表前缀
    'db.persistent' => false,         // 是否长连接

    // 用户密码加密密钥
    'password_key' => '',
    'admin_password_key' => '',
];
