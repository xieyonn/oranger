<?php
/**
 * 密钥相关
 *
 * @author: xieyong <qxieyongp@163.com>
 * @Date: 2017/8/23
 * @Time: 23:36
 */

$config = require('./config.php');

return [
    // 用户密码加密密钥
    'password_key' => $config['password_key'],

    // 管理员用户密码加密密钥
    'admin_password_key' => $config['admin_password_key'],
];
