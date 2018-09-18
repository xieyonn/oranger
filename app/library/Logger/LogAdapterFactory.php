<?php

/**
 *@brief 日志适配器工厂类
 *
 *@author xieyong <qxieyongp@163.com>
 *@date 2018-03-21
 */

namespace App\Library\Logger;

class LogAdapterFactory
{
    protected static $m_type_class = [
        self::ADAPTER_TYPE_FILE    => '\App\Library\Logger\Adapter\FileWriter',
        self::ADAPTER_TYPE_CONSOLE => '\App\Library\Logger\Adapter\ConsoleWriter',
    ];

    const ADAPTER_TYPE_FILE    = 'file';
    const ADAPTER_TYPE_CONSOLE = 'console';

    /**
     * 日志适配器工厂方法
     *
     * @param $adapter_type
     * @param $params
     */
    public static function getLogAdapter($adapter_type)
    {
        $adapter_classname = '';
        if (empty($adapter_type) || ! \array_key_exists($adapter_type, self::$m_type_class)) {
            // 默认写文件
            $adapter_classname = self::$m_type_class[self::ADAPTER_TYPE_FILE];
        } else {
            $adapter_classname = self::$m_type_class[$adapter_type];
        }

        $reflectInstance = new \ReflectionClass($adapter_classname);

        return $reflectInstance->newInstanceArgs();
    }
}
