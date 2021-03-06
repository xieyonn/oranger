<?php

/**
 * 写文件类
 *
 * @author: xieyong <qxieyongp@163.com>
 * @Date: 2017/8/19
 * @Time: 14:38
 */

namespace Oranger\Library\Logger\Adapter;

use Oranger\Library\Logger\LogWriter;

class FileWriter implements LogWriter
{
    /**
     * @var string 文件路径
     */
    protected $dir = '';

    /**
     * @var int 日志文件权限
     */
    protected $file_permissions = 0777;

    public function __construct($dir = '')
    {
        $this->dir = $dir !== '' ? $dir : LOG_PATH;
    }

    /**
     * 写到文件
     * @author: xieyong <xieyong@xiaomi.com>
     * @param string $log_name 日志名（文件名）
     * @param string $content  内容
     */
    public function write($log_name, $content)
    {
        $dir = rtrim($this->dir, DIRECTORY_SEPARATOR);

        if (!file_exists($dir)) {
            mkdir($dir, $this->file_permissions);
        }

        // 写日志
        $file = $dir . DIRECTORY_SEPARATOR . $log_name . '.log';
        file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
    }
}
