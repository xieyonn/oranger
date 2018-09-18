<?php
/**
 * @brief 日志器配置文件
 * 日志会服务会加上 _log 后缀
 * 调用方式: DI::getInstance()->get('debug_log')
 *
 * @author xieyong <qxieyongp@163.com>
 * @date 2018-03-23
 */
use App\Library\Logger\LogAdapterFactory;

return [
    // debug
    [
        'name'    => 'debug',
        'type'    => LogAdapterFactory::ADAPTER_TYPE_FILE,
        'options' => [],
    ],
    // 错误日志
    [
        'name'    => 'error',
        'type'    => LogAdapterFactory::ADAPTER_TYPE_FILE,
        'options' => [],
    ],
    // 数据库连接日志
    [
        'name'    => 'db_connection',
        'type'    => LogAdapterFactory::ADAPTER_TYPE_FILE,
        'options' => [],
    ],
    // 数据库日志
    [
        'name'    => 'database',
        'type'    => LogAdapterFactory::ADAPTER_TYPE_FILE,
        'options' => [],
    ],
    // 命令行输出
    [
        'name'    => 'console',
        'type'    => LogAdapterFactory::ADAPTER_TYPE_CONSOLE,
        'options' => [
            'delay_write' => false,
        ],
    ],
    // 命令行日志记录
    [
        'name'    => 'command',
        'type'    => LogAdapterFactory::ADAPTER_TYPE_FILE,
        'options' => [],
    ],
];
