<?php
/**
 * @brief 控制台输出
 *
 * @author xieyong <qxieyongp@163.com>
 * @date 2018-03-21
 */

namespace Oranger\Library\Logger\Adapter;

use Oranger\Library\Logger\LogWriter;

class ConsoleWriter implements LogWriter
{
    public function __construct()
    {
    }

    public function write($log_name, $content)
    {
        if (PHP_SAPI === 'cli') {
            $print = '[' . $log_name . ']' . $content;
            echo $print;
        }
    }
}
