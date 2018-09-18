<?php
/**
 * 日志工厂类
 *
 * @author: xieyong <qxieyongp@163.com>
 * @Date: 2017/8/19
 * @Time: 21:43
 */

namespace App\Library\Logger;

use App\Library\Logger\Adapter\FileWriter;

class LoggerFactory
{
    /**
     * 获取日志记录对象
     * @author: xieyong <qxieyongp@163.com>
     * @param string $log_name 日志名
     *
     * @return \Closure
     */
    public static function getLogger(string $log_name, string $adapter_type, array $option = [])
    {
        $logger_closure =  function () use ($log_name, $adapter_type, $option) {
            $writer = LogAdapterFactory::getLogAdapter($adapter_type);

            return new Logger($log_name, $writer, $option);
        };

        return $logger_closure;
    }
}
