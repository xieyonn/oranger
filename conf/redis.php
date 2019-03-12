<?php
/**
 * @brief redis配置文件
 *
 * @author xieyong <qxieyongp@163.com>
 * @date 2019-03-12 09:42
 */

$config = require(__DIR__ . DIRECTORY_SEPARATOR . 'config.php');

return [
    'redis' => [
        'host' => $config['redis.host'],
        'port' => $config['redis.port'],
    ]
];
