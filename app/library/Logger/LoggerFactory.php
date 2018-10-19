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
     * @author: xieyong <xieyong@xiaomi.com>
     * @param string $log_name 日志名
     * @param mixed $name 适配器类型
     * @param array $option 配置参数
     *
     * @return \Closure
     */
    public static function getLogger($log_name, $adapter_type, $option = [])
    {
        $logger_closure =  function () use ($log_name, $adapter_type, $option) {
            $writer = [];
            if (is_array($adapter_type)) {
                foreach ($adapter_type as $entry) {
                    $writer[] = LogAdapterFactory::getLogAdapter($entry);
                }
            } else {
                $writer[] = LogAdapterFactory::getLogAdapter($adapter_type);
            }

            return new Logger($log_name, $writer, $option);
        };

        return $logger_closure;
    }
}
