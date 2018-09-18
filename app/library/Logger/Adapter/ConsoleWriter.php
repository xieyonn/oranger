<?php
/**
 * @brief 控制台输出
 *
 * @author xieyong <qxieyongp@163.com>
 * @date 2018-03-21
 */

namespace App\Library\Logger\Adapter;

use App\Library\Logger\LogWriter;

class ConsoleWriter implements LogWriter
{
    public function __construct()
    {
    }

    public function write(string $log_name, string $content)
    {
        $print = '[' . $log_name . ']' . $content;
        echo $print;
    }
}
