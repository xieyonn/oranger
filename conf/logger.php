<?php
/**
 * @brief 日志器配置文件
 * 日志会服务会加上 _log 后缀
 * 调用方式: DI::getInstance()->get('debug_log')
 *
 * @author xieyong <qxieyongp@163.com>
 * @date 2018-03-23
 */
use Oranger\Library\Logger\LogAdapterFactory;
use Oranger\Library\Logger\Logger;

return [
    'uncaught_error_log' => [
        'name'    => 'uncaught_error', // 未捕获异常 or 错误
        'type'    => [
            LogAdapterFactory::ADAPTER_TYPE_FILE,
            LogAdapterFactory::ADAPTER_TYPE_CONSOLE,
        ],
        'options' => [
            'log_threshold' => Logger::EXCEPTION,
            // 'delay_write' => false,
            'log_trace' => true,
        ],
    ],
    // debug
    'debug_log' => [
        'name'    => 'debug',
        'type'    => [
            LogAdapterFactory::ADAPTER_TYPE_FILE,
            LogAdapterFactory::ADAPTER_TYPE_CONSOLE,
        ],
        'options' => [
            'delay_write' => false,
            'log_trace' => false,
        ],
    ],
    // 错误日志
    'error_log' => [
        'name'    => 'error',
        'type'    => [
            LogAdapterFactory::ADAPTER_TYPE_FILE,
            LogAdapterFactory::ADAPTER_TYPE_CONSOLE,
        ],
        'options' => [],
    ],
    // php错误日志
    'php_error_log' => [
        'name'    => 'php_error',
        'type'    => [
            LogAdapterFactory::ADAPTER_TYPE_FILE,
            LogAdapterFactory::ADAPTER_TYPE_CONSOLE,
        ],
        'options' => [],
    ],
    // 数据库连接日志
    'db_connection_log' => [
        'name'    => 'db_connection',
        'type'    => [
            LogAdapterFactory::ADAPTER_TYPE_FILE,
            LogAdapterFactory::ADAPTER_TYPE_CONSOLE,
        ],
        'options' => [],
    ],
    // 数据库日志
    'database' => [
        'name'    => 'database',
        'type'    => [
            LogAdapterFactory::ADAPTER_TYPE_FILE,
            LogAdapterFactory::ADAPTER_TYPE_CONSOLE,
        ],
        'options' => [],
    ],
    // 命令行输出
    'console_log' => [
        'name'    => 'console',
        'type'    => [
            LogAdapterFactory::ADAPTER_TYPE_FILE,
            LogAdapterFactory::ADAPTER_TYPE_CONSOLE,
        ],
        'options' => [
            'delay_write' => false,
            'log_trace' => false,
        ],
    ],
];
